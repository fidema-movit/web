<?php include("template/cabecera.php");?>
<div class="jumbotron">
    <h1 class="display-3">Registrase</h1>
    <p class="lead">Llevamos el mejor proceso mas eficas</p>
    <hr class="my-2">
    <p>More info</p>
    <p class="lead">
        <a class="btn btn-primary btn-lg" href="Jumbo action link" role="button">Jumbo action name</a>
    </p>
</div>
<div class="container mt-3">
  <form>

    <div class = "form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary">Sign In</button>
    </form>
  <h2>Custom File</h2>
  <p>To create a custom file upload, wrap a container element with a class of .custom-file around the input with type="file". Then add the .custom-file-input to the file input:</p>
  <form action="/action_page.php">
    <p>Custom file:</p>
    <div class="custom-file mb-3">
      <input type="file" class="custom-file-input" id="customFile" name="filename">
      <label class="custom-file-label" for="customFile">Choose file</label>
      
    </div>
    
    <p>Default file:</p>
    <input type="file" id="myFile" name="filename2">
  
    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form
  <div class="form-group">
    <label for=""></label>
    <input type="text" name="" id="" class="form-control" placeholder="" aria-describedby="helpId">
    <small id="helpId" class="text-muted">Help text</small>
  </div>
</div>


<?php include("template/pie.php");?>
