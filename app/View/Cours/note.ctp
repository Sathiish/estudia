<p>Note moyenne:  <?php if(ceil(substr($moyenne,0,4)) >=1) echo $this->Html->image(ceil(substr($moyenne,0,4)).'etoiles.png', array('alt' => 'note')). ' ('.substr($moyenne,0,4); ?>/5)</p>
<p>Votre note: <?php if(ceil($note) >=1) echo $this->Html->image(ceil($note).'etoiles.png'). ' ('.$note; ?>/5)</p>
                