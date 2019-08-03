<?php include_once 'header.php'; ?>
<div class="container text-center mt-3">
  <form action="loginact.php" method="post" >
  <div class="form-group">
    <label for="exampleInputEmail1">Email адрес</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Въведете email">
    <small id="emailHelp" class="form-text text-muted"></small>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Парола</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Въведете парола">
  </div>
  <button type="submit" name="loginbutton" class="btn btn-primary">Вход</button>
</form>
</div>
</body>
</html>
