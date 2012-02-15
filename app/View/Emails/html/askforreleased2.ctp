<p><?php $p = current($p); ?></p>

<p>Le cours intitulé <?php echo $p['name']; ?> attend d'être publié.</p>

<p><?php echo $this->Html->link("Mettre en ligne",$this->Html->url($link,true)); ?></p>