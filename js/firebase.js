// README: this file includes the basic setup for firebase initialization && html prompts


// INSTRUCTION: copy & paste below to html script
// <script src="./js/firebase.js" type="module"></script>

import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-app.js";
import { getAuth, onAuthStateChanged, signOut } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-auth.js";
import { getDatabase, ref } from "https://www.gstatic.com/firebasejs/9.8.1/firebase-database.js";

const firebaseConfig = {
  apiKey: "AIzaSyB4YlBrlXQ158Xw14W5CcSZtA_6AdRufvM",
  authDomain: "atto-beta.firebaseapp.com",
  projectId: "atto-beta",
  storageBucket: "atto-beta.appspot.com",
  messagingSenderId: "309318310679",
  appId: "1:309318310679:web:38cf55e02292ee39247552"
};
const app = initializeApp(firebaseConfig);
const db = getDatabase(app);

// console - user signed in status check on every page
onAuthStateChanged(getAuth(), (user) => {
  if (user){
      console.log(user.uid+" is signed in as "+user.displayName);
  } else {
      console.log("no one is signed in");
  }
});





// README: variables and functions below focus on exporting to specific html files




// define currentUser
export const user = getAuth().currentUser;

// define references to database
export let userListRef;
if (user){
  userListRef = ref(db, "userList(s)"+user.uid);
} 
export const displayNameRef = ref(db, "displayName(s)");

// change html header based on login status
export function changeHeader(){
  const loggedOut_header = '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="index.html">Attōβ</a></div><div class="header_right"><form id="searchbar"><input name="query" type="search" placeholder="Search..." autocomplete="off" aria-label="Search" aria-controls="top-search"></form><ul id="login_signup_btns"><li><a href="">Log in</a></li><li><a href="signup.html">Sign up</a></li></ul></div >';
  const loggedIn_header = '<div class="header_left"><i id="hidden_navbar" class="material-icons">dehaze</i><a id="logo" href="index.html">Attōβ</a></div><div class="header_right"><div id="ask_answer_btns"><a href="ask.html">Ask</a><a href="answer.html">Answer</a></div><ul id="logout_dashbboard_btns"><li><a href="">Log out</a></li><li><i id="userdashboard_btn" class="material-icons">perm_identity</i></li></ul></div>';
  if (user){
    $('header').append(loggedIn_header);
  } else {
    $('header').append(loggedOut_header);
  };
};

// log out command
export function logOut(){
  $("#logOut_btn").on("click", function(){
    if (user){
      signOut(getAuth())
        .then(() => {
          console.log("log out successful");
        })
        .catch((error) => {
            console.log(error);
        });
    };
  });
};

// check if displayName is unique
export function uniqueDisplayName(){
  $("#change_displayName_btn").on("click", function(){
    // grab input from inputted displayName
    // parse through the displayName database in array(?) format to make sure new input is unique
  })
};