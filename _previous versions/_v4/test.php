<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/btw007dhn58b3dug4r99dlomq12k6gykkrt28rzht8cboy1i/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
  <textarea>
    Welcome to TinyMCE!
  </textarea>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
   });
  </script>
</body>
</html>