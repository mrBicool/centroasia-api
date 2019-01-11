<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom styles for this template -->
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
	<!-- Navigation -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
      	<div class="navbar-brand">
      		Food Asia
      	</div>  
      </div>
    </nav> -->

	<!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">FRANCHISE INQUIRY</h1>
          <table> 
	          	<tr>
	          		<td class="td-col">Proposed location</td>
	          		<td> {{ $proposed_location }} </td>
	          	</tr>
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
	          		<td class="td-col">Contact number</td>
	          		<td> {{ $contact_number }} </td>
	          	</tr>
	          	<tr>
	          		<td class="td-col">Home address</td>
	          		<td> {{ $home_address }} </td>
	          	</tr>
	          	<tr>
	          		<td class="td-col">Remarks</td>
	          		<td> {{ $remarks }} </td>
	          	</tr> 
          </table>
        </div>
      </div>
    </div>

</body>
</html>