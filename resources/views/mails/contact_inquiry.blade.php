<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
   <!-- Bootstrap core CSS -->
    <style>
      @media screen {
        @font-face {
          font-family: 'Lato';
          font-style: normal;
          font-weight: 400;
          src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
        } 
    }

      body {
        font-family: "Lato", "Lucida Grande", "Lucida Sans Unicode", Tahoma, Sans-Serif;
      }

      table {
        border-collapse: collapse;
    }
      td, th {
        border: 1px solid gray;
        padding-left: 5px; 
        padding-right: 5px;
    }
    td.td-col{
      font-weight: bold;
    }
    </style>
</head>
<body>
   
  <h1>ABOUT INQUIRY</h1>
  <table> 
      <tr>
        <td class="td-col">First name</td>
        <td> {{ $first_name }} </td>
      </tr>
      <tr>
        <td class="td-col">Last name</td>
        <td> {{ $last_name }} </td>
      </tr>
      <tr>
        <td class="td-col">Email address</td>
        <td> {{ $email_address }} </td>
      </tr>
      <tr>
        <td class="td-col">Contact #</td>
        <td> {{ $contact_number }} </td>
      </tr> 
      <tr>
        <td class="td-col">Subject</td>
        <td> {{ $subject }} </td>
      </tr>
      <tr>
        <td class="td-col">Message</td>
        <td> {{ $c_message }} </td>
      </tr>
  </table>

</body>
</html>