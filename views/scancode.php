<!DOCTYPE html>
<html>
  <head>
    <title>ФМИ Паркинг - Сканиране</title>
    <script type="text/javascript" src="https://rawcdn.githack.com/tobiasmuehl/instascan/4224451c49a701c04de7d0de5ef356dc1f701a93/bin/instascan.min.js"></script>
  </head>
  <body>
    <video id="preview"></video>
    <script type="text/javascript">
      const scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
      
      scanner.addListener('scan', function (payload) {
        const content = JSON.parse(payload);

        if (content.hasOwnProperty('id')) {
            fetch("/controllers/api.php/checkcode?id=" + content.id)
                .then(console.log)
                .catch(console.error);
        } else {
            console.error('Invalid QR Code');
        }
      });

      Instascan.Camera.getCameras().then(function (cameras) {
        if (cameras.length > 0) {
          scanner.start(cameras[0]);
        } else {
          console.error('No cameras found.');
        }
      }).catch(function (e) {
        console.error(e);
      });
    </script>
  </body>
</html>