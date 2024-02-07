<div class="wrap" id="wpcSimpleTranslate">
  <h1>WPC Simple Translate</h1>

    <p>WPC Simple Translate allows you to translate multilingual WordPress site.</p>
    <p>It allows you to translate texts in places where other popular plugins usually  have difficulties in translating and you have to duplicate and keep the same slider, form, gallery, page builders widgets... in different languages.</p>
    <p>WPC Simple Translate helps you to translate everything despite of themes or plugins specifications.</p>
    <p>Currently it is working with Polylang and WPML plugins using plugins just for detecting frontend language.</p>


    <h3>Features</h3>
    <ul>
      <li>Easy to use</li>
      <li>Fully compatible with all themes and plugins</li>
      <li>Ability to translate dynamic strings added by WordPress, plugins and themes.</li>
      <li>You can use as many languages as you want.</li>
    </ul>

  <p>It is easy to use, just put your texts in bellow format</p>

  <div class="copyToClipboard shortcode" onclick="CopyToClipboard('shortcode-1')" title="<?= __( "Copy", ET_PREFIX ) ?>">
    &#x3C;p&#x3E;<span id="shortcode-1">[:en]Hello World[:fr]Bonjour le monde[:de]Hallo Welt[:]</span>&#x3C;/p&#x3E;
    <span class="dashicons dashicons-admin-page shortcode-1-copy"></span>
  </div>

  <hr>
    <h2 class="preview-title">Preview Example</h2>
    <select id="et-demo-lng-switch" onchange="etDemo(this.value)">
      <option value="en">en - English</option>
      <option value="fr">fr - French</option>
      <option value="de">de - German</option>
    </select>

    <h3>Content</h3>

    <div class="et-demo">
      &#x3C;p&#x3E;<span id="et-demo">Hello World</span>&#x3C;/p&#x3E;
    </div>

    <h3>Code</h3>

    <div class="et-demo-php">
      &#x3C;?php<br>
      echo apply_filters("wpcSimpleTranslate", "[:en]Hello World[:fr]Bonjour le monde[:de]Hallo Welt[:]");<br>
      ?&#x3E;
      <br><br>
      <p>
        returns: <span id="et-demo-php">Hello World</span>
      </p>
    </div>
</div>

<script type="text/javascript">
  
function etDemo(lng){
  var etStr = "";
  switch(lng) {
    case "en":
      etStr = "Hello World";
      break;
    case "fr":
      etStr = "Bonjour le monde";
      break;
     case "de":
      etStr = "Hallo Welt";
      break;
  }
  document.getElementById('et-demo').innerHTML = etStr;
  document.getElementById('et-demo-php').innerHTML = etStr;
}

// Copy To Clipboard
function CopyToClipboard(id){
    var r = document.createRange();
    r.selectNode(document.getElementById(id));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(r);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();
    alert("Copied to clipboard!");
}

</script>