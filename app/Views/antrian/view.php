<div id="load" class="content"></div>

<!-- SCRIPT -->
<script src="<?= $this->ASSETS_URL ?>js/jquery-3.6.0.min.js"></script>

<script>
  var mode = "<?= $data['modeView'] ?>"

  $(document).ready(function() {
    loadContent();
  });

  $("body").dblclick(function() {
    (".modal").hide();
  })

  function loadContent() {
    $(".loaderDiv").fadeIn("fast");
    $("div#load").load("<?= URL::BASE_URL ?>Antrian/loadList/" + <?= $data['modeView'] ?>);
    $(".loaderDiv").fadeOut("slow");
  }

  $('span.clearTuntas').click(function() {
    $("div.backShow").removeClass('d-none');
  });
</script>