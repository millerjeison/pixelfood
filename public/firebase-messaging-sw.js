importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');
let config = {
        apiKey: "AIzaSyA6ngEoX_-ngKeQa8Kq2AWps_C2w-4JliY",
        authDomain: "foodappi-f4f14.firebaseapp.com",
        projectId: "foodappi-f4f14",
        storageBucket: "foodappi-f4f14.appspot.com",
        messagingSenderId: "1007415649902",
        appId: "1:1007415649902:web:42dedc623d98bdee97687f",
        measurementId: "G-MSY9XE6JW3",
 };
firebase.initializeApp(config);
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: '/images/default/firebase-logo.png'
    };
    self.registration.showNotification(notificationTitle, notificationOptions);
});
