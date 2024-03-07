<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p ><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
  <script>
        setTimeout(function() {
            document.querySelector('.error').style.display = 'none'
        }, 1500)
    </script>
<?php  endif ?>