
    importScripts(
      'https://www.gstatic.com/firebasejs/9.8.1/firebase-app-compat.js'
    )
    importScripts(
      'https://www.gstatic.com/firebasejs/9.8.1/firebase-messaging-compat.js'
    )
    firebase.initializeApp({"apiKey":"AIzaSyCrm8HDTNE0zrb268QJBs-kuwZNekwLZNI","authDomain":"sooog-2180d.firebaseapp.com","projectId":"sooog-2180d","storageBucket":"sooog-2180d.appspot.com","messagingSenderId":"404912388323","appId":"1:404912388323:web:0e94f8b9955f8f1c1eedd6","measurementId":"G-ZS26F458RH"})

    // Retrieve an instance of Firebase Messaging so that it can handle background
    // messages.
    const messaging = firebase.messaging()

    