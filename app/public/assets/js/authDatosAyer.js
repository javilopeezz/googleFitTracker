$(function () {

    var fragmentString = location.hash.substring(1);

    var params = {};
    var regex = /([^&=]+)=([^&]*)/g, m;
    while (m = regex.exec(fragmentString)) {
      params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }
    if (Object.keys(params).length > 0) {
      localStorage.setItem('oauth2-test-params', JSON.stringify(params) );
      if (params['state'] && params['state'] == 'pass-through value') {
        getMetricsYesterday();
      }
    }

    function getMetricsYesterday() {
        getMetricsForDays(1, 1);
    }
  
    // If there's an access token, try an API request.
    // Otherwise, start OAuth 2.0 flow.
    function getMetricsForDays(fromDaysAgo, toDaysAgo) {

        var start = new Date();
        start.setHours(0, 0, 0, 0);
        start.setDate(start.getDate() - toDaysAgo);

        var end = new Date();
        end.setHours(23, 59, 59, 999);
        end.setDate(end.getDate() - fromDaysAgo);

        var params = JSON.parse(localStorage.getItem('oauth2-test-params'));
        if (params && params['access_token']) {
        
            var request = {
                "aggregateBy": [
                    {
                    "dataTypeName": "com.google.step_count.delta",
                    "dataSourceId": "derived:com.google.step_count.delta:com.google.android.gms:estimated_steps"
                    },
                    {
                    "dataTypeName": "com.google.weight.summary",
                    "dataSourceId": "derived:com.google.weight:com.google.android.gms:merge_weight"
                    },
                    {
                    "dataTypeName": "com.google.distance.delta",
                    "dataSourceId": "derived:com.google.distance.delta:com.google.android.gms:merge_distance_delta"
                    },
                    {
                    "dataTypeName": "com.google.calories.expended",
                    "dataSourceId": "derived:com.google.calories.expended:com.google.android.gms:merge_calories_expended"
                    }
                ],
                "bucketByTime": { "durationMillis": 86400000 },
                "startTimeMillis": start.getTime(),
                "endTimeMillis": end.getTime()
            };

            $.ajax({
                url: 'https://www.googleapis.com/fitness/v1/users/me/dataset:aggregate',
                method: 'POST',
                headers: {
                  'Authorization': 'Bearer ' + params['access_token']
                },
                contentType: 'application/json',
                data: JSON.stringify(request, null, 2),
                success: function(response) {
                  if (response.bucket[0].dataset[0].point.length > 0) {
                    steps = response.bucket[0].dataset[0].point[0].value[0].intVal;
                  }else{
                    steps = 0;
                  }
              
                  if (response.bucket[0].dataset[1].point.length > 0) {
                    weight = response.bucket[0].dataset[1].point[0].value[0].fpVal;
                  }else{
                    weight = 0;
                  }
              
                  if (response.bucket[0].dataset[2].point.length > 0) {
                    distance = response.bucket[0].dataset[2].point[0].value[0].fpVal;
                  }else{
                    distance = 0;
                  }
              
                  if (response.bucket[0].dataset[3].point.length > 0) {
                    calories = response.bucket[0].dataset[3].point[0].value[0].fpVal;
                  }else{
                    calories = 0;
                  }

                  $('#pasosAyer').html(steps);
                  $('#pesoAyer').html(weight.toFixed(2));
                  $('#distanciaAyer').html(distance.toFixed(2));
                  $('#caloriasAyer').html(calories.toFixed(2));

                  console.log(response);
                },
                error: function(error) {
                  console.log(error);
                }
              });
              
        } else {
            oauth2SignIn();
        }
    }

})