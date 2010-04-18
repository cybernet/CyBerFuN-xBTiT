<?php

// CyBerFuN.ro & xList.ro

// xList .::. Twitter Block
// http://tracker.cyberfun.ro/
// http://www.cyberfun.ro/
// http://xlist.ro/
// Modified By CyBerNe7

echo("<div id=\"twtr-profile-widget\"></div>
<script src=\"http://widgets.twimg.com/j/1/widget.js\"></script>
<link href=\"http://widgets.twimg.com/j/1/widget.css\" type=\"text/css\" rel=\"stylesheet\">
<script>
new TWTR.Widget({
  profile: true,
  id: 'twtr-profile-widget',
  loop: true,
  width: 190,
  height: 375,
  theme: {
    shell: {
      background: '#A7B9CA',
      color: '#ffffff'
    },
    tweets: {
      background: '#c9ddff',
      color: '#444444',
      links: '#618ea1'
    }
  }
}).render().setProfile('xlist_ro').start();
</script>");
?>