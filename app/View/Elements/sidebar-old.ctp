 <div class="sidebar">
    

            <div class="mes_infos">
                <div class="fond_blanc">
                   <img src="/img/<?php echo $_SESSION['Auth']['User']['avatar']; ?>" class="profile" alt="profile" width="80" height="65"/>
                   <img src="/img/cours/bottom_matiere.png" class="bottom" />
                
                <?php echo '<span class="capitalize" style="color:#333;font-weight: bold; margin-left:10px">'.$_SESSION['Auth']['User']['username'].'</span>';?><br />
                <a class="message_profil" href="#"><span style="color:#00ccff">(0)</span> message</a><br />
                <a class="message_profil" href="#"><span style="color:#00ccff">(0)</span> alerte</a><br />
                <?php echo $this->Html->image("sidebar/plus2.png", array("alt" => "Edition profil", "title"=>"Editer mon profil", "class"=>"right",'url' => array('controller'=>'users', 'action' => 'edit'))); ?>
                </div>
            </div>

      <div class="menu_vert_resize">
          <div id="nav_onglet">
               <ul>
                   <li class="tdb"><a href="/dashboard" ><span class="uppercase">Mon dashboard</span></a></li><br />
                   <li class="mes_cours"><a href="/ressources/manager" ><span class="uppercase">Mes cours</span></a></li><br />
                   <li><a href="/messages" ><span class="uppercase">Ma messagerie</span></a></li><br />
              
               </ul>
              
          </div>
      
    </div>
<!--    
           <div class="fb-like-box  fb_iframe_widget " data-href="http://fr-fr.facebook.com/pages/ZeSchool/176348839105396?v=wall" data-width="240" data-show-faces="true" data-stream="false" data-header="true"><span><iframe id="f23f0e340" name="fa189b7fc" scrolling="no" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; overflow-x: hidden; overflow-y: hidden; height: 290px; width: 240px; " class="fb_ltr" src="http://www.facebook.com/plugins/likebox.php?channel=https%3A%2F%2Fs-static.ak.fbcdn.net%2Fconnect%2Fxd_proxy.php%3Fversion%3D3%23cb%3Df239bb144%26origin%3Dhttp%253A%252F%252Fzeschool.fr%252Ff1675a6fe%26relation%3Dparent.parent%26transport%3Dpostmessage&amp;colorscheme=light&amp;header=true&amp;height=290&amp;href=http%3A%2F%2Ffr-fr.facebook.com%2Fpages%2FZeSchool%2F176348839105396%3Fv%3Dwall&amp;locale=fr_FR&amp;sdk=joey&amp;show_faces=true&amp;stream=false&amp;width=240"></iframe></span></div>
 -->
        </div>