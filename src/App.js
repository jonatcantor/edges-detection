import React from "react";

class App extends React.Component {
  webSocket;
  canvasRef;
  canvasContext;
  canvasVideo;

  constructor() {
    super();

    this.webSocket = new WebSocket(process.env.REACT_APP_SOCKET_PROTOCOL + '/' + process.env.REACT_APP_SOCKET_FILE);
    this.canvasRef = React.createRef();
    this.canvasVideo = document.createElement('video');
  }

  componentDidMount() {
    this.canvasContext = this.canvasRef.current.getContext('2d');

    // Socket open event
    this.webSocket.onopen = (event) => {
      // console.log('Connected - status: ' + this.webSocket.readyState);
      // console.log('Connected event:');
      // console.log(event);
    }

    // Socket message event
    this.webSocket.onmessage = (event) => {
      // console.log('Received - status: ' + this.webSocket.readyState);
      // console.log('Message event:');
      // console.log(event);

      const webImage = new Image();
      webImage.src = event.data;
    
      webImage.onload = () => {
        this.updateStreamImage();
    
        this.canvasContext.drawImage(webImage, 0, 0, this.canvasRef.current.width, this.canvasRef.current.height);
      }
    }

    // Socket close event
    this.webSocket.onclose = (event) => {
      // console.log('Disconnected - status: ' + this.webSocket.readyState);
      // console.log('Disconnected event:');
      // console.log(event);
    }

    if(!navigator.mediaDevices) {
      alert('HTTPS error: make sure you are using https or if you are in a local environment, that you allow "treat insecure origin as safe" in your navigator configuration');
      return;
    }

    const getMedia = navigator.mediaDevices.getUserMedia({
      audio: false,
      video: {
        facingMode: { exact: "environment" },
        frameRate: { ideal: 30, max: 60 }
      },
    });

    getMedia.then((stream) => {
      this.canvasVideo.srcObject = stream;
    
      this.canvasVideo.onloadeddata = () => {
        this.canvasRef.current.width = this.canvasVideo.videoWidth;
        this.canvasRef.current.height = this.canvasVideo.videoHeight;
        this.canvasVideo.play();
        this.updateStreamImage();
      }
    }).catch((error) => {
      alert('Camera error: ' + error);
    });
  }
  
  updateStreamImage() {
    this.canvasContext.drawImage(this.canvasVideo, 0, 0, this.canvasRef.current.width, this.canvasRef.current.height);
    this.webSocket.send(this.canvasRef.current.toDataURL('image/jpeg', 0.5));
    this.canvasContext.clearRect(0, 0, this.canvasRef.current.width, this.canvasRef.current.height);
  }
  
  render() {
    return (
      <canvas ref={ this.canvasRef }></canvas>
    );
  }
}

export default App;
