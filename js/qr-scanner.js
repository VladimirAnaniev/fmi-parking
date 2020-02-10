document.addEventListener('DOMContentLoaded', () => {
   const scanner = new Instascan.Scanner({video: document.getElementById('preview')});

   scanner.addListener('scan', handleQrCode);

   Instascan.Camera.getCameras()
      .then(cameras => startFirstCamera(scanner, cameras))
      .catch(console.error);
});

const handleQrCode = payload => {
   try {
      const content = JSON.parse(payload);

      if (content.hasOwnProperty('id')) {
         openGate(content);
      } else {
         appendMessage('Invalid QR Code');
      }
   } catch (err) {
      appendMessage('Invalid QR Code');
   }
};

const openGate = content => {
   fetch('/controllers/api.php/checkcode?id=' + content.id)
      .then(response => {
         if(response.status !== 200) {
            throw new Error(response.status);
         }

         appendMessage(`Отварям бариерата, ${content.name}`);
      })
      .catch(err =>  {
         if(err.message == 401) {
            appendMessage("Не можете да отворите бариерата по това време!");
         } else {
            appendMessage('Проблем с връзката към сървъра.')
         }
      });
};

const appendMessage = message => {
   const messageElement = document.querySelector('#message');
   messageElement.textContent = message;

   setTimeout(() => (messageElement.textContent = ''), 5000);
};

const startFirstCamera = (scanner, cameras) => {
   if (cameras.length > 0) {
      scanner.start(cameras[0]);
   } else {
      appendMessage('No cameras found.');
   }
};
