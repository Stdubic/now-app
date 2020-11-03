<!DOCTYPE html>
<html>
<head>
    <title>web view post message</title>
</head>
<body>

<script type="text/javascript">

    const data = {
        success: <?php if ($success) {echo  "true" ;} else {echo  "false" ;}?>,
        error_description: [ "<?php  if ($error_description) {echo  $error_description ;} else {echo  false ;} ?>" ]
    };

    window.ReactNativeWebView.postMessage(btoa(JSON.stringify(data)));

</script>

</body>
</html>