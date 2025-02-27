<!DOCTYPE html>
<!-- Tab depth matters -->
<html lang="en">
  <head>
    <!-- Get around the favicon.ico request  -->
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boodschappenlijst</title>
    <style>
      * {
        /* Why are not all fonts 15px? */
        font-size: 15px;
      }
      nav {
        /* Lining up the buttons in a row */
        display: flex;
      }
      th, td {
        background: #2a6;
        font-size: 25px;
        text-align: center;
        padding: 10px;
      }
      td {
        background: #6a2;
      }
      table, label {
        margin: 10px;
      }
      body, input {
        font-size: 15px;
        background: #000;
        color: #ff8;
        margin: 10px;
      }
      input {
        background: #a62;
      }
      input[type=text]:focus {
        background: #642;
      }
      button, input[type=submit] {
        background: #26a;
        margin: 10px;
      }
      input[type=submit]:hover {
        background: #246;
      }
      input[class=poster] {   
        color: #222;    
        background: #4a4;
      }
      input[class=poster]:hover {
        color: #ff8;
        background: #262;
      }
      input[class=deleter] { 
        color: #222;      
        background: #f44;
      }
      input[class=deleter]:hover {
        color: #ff8;
        background: #822;
      }
      button {
        color: #ff8;
        background: #a26;
      }
      button:hover {
        background: #624;
      }
      .writing {
        color: #b22;
        margin: 10px;
      }
    </style>
  </head>
