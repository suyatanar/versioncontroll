<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get Data</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="request-api">
        <form method="post" action="data.php" name="getdata" id="getdata" onSubmit="actionOnSubmit()">
            <div class="form-control">
                <select name="method_name">
                    <option value="" selected disabled>Select Method</option>
                    <option value="get">GET</option>
                    <option value="post">POST</option>
                </select>
            </div>
            <div class="form-control">
                <input type="text" name="request_url" placeholder="Enter request URL" id="request_url">
            </div>
            <div class="form-control">
                <input type="submit" name="getdata" value="Submit">
            </div>
            <div class="full-width">
                <textarea name="update_data" rows="10" placeholder="Update data with json format"></textarea>
            </div>
            
        </form>
    </div>

    <div class="request-api hint">
        <h3>Request url should be:</h3>
        <ul>
            <li><?=HOME_URL;?>/data.php/?id=1</li>
            <li><?=HOME_URL;?>/data.php/?timestamp=1647570247</li>          
            <li><?=HOME_URL;?>/data.php/2</li>
            <li><?=HOME_URL;?>/data.php/get_all_records</li>
        </ul>
        <p>Json Format</p>
        <pre>
            {
                "name": "v.0.2",
                "timestamp": "2022-03-18 10:24:07"
            }
        </pre>
    </div>
</body>
<script>

function actionOnSubmit(){
    var e = document.getElementById("request_url");
    var formaction = e.value;
    document.getdata.action = formaction;
}
</script>
</html>