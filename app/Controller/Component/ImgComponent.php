<?php
class ImgComponent extends Component  {
	

        /**
         * Permet de cropper une image au format png/jpg et gif et 
         *
         * @param Controller $controller Controller with components to beforeRedirect
         * @param string|array $url Either the string or url array that is being redirected to.
         * @param integer $status The status code of the redirect
         * @param boolean $exit Will the script exit.
         * @return array|null Either an array or null.
         */
	function crop($img,$dest,$largeur=0,$hauteur=0){
                $dimension=getimagesize($img);
                $ratio = $dimension[0] / $dimension[1];
                // Création des miniatures
                if($largeur==0 && $hauteur==0){ $largeur = $dimension[0]; $hauteur = $dimension[1]; }
                  else if($hauteur==0){ $hauteur = round($largeur / $ratio); }
                else if($largeur==0){ $largeur = round($hauteur * $ratio); }

        		if($dimension[0]>($largeur/$hauteur)*$dimension[1] ){ $dimY=$hauteur; $dimX=round($hauteur*$dimension[0]/$dimension[1]);}
        		if($dimension[0]<($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=round($largeur*$dimension[1]/$dimension[0]);}
        		if($dimension[0]==($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=$hauteur;}

                if($dimension[0]>($largeur/$hauteur)*$dimension[1] ){ $dimY=$hauteur; $dimX=round($hauteur*$dimension[0]/$dimension[1]); $decalX=($dimX-$largeur)/2; $decalY=0;}
                if($dimension[0]<($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=round($largeur*$dimension[1]/$dimension[0]); $decalY=($dimY-$hauteur)/2; $decalX=0;}
                if($dimension[0]==($largeur/$hauteur)*$dimension[1]){ $dimX=$largeur; $dimY=$hauteur; $decalX=0; $decalY=0;}
                $miniature =imagecreatetruecolor ($largeur,$hauteur);
                if(substr($img,-4)==".jpg" || substr($img,-4)==".JPG" || substr($img,-4)==".jpeg" || substr($img,-4)==".JPeG"){$image = imagecreatefromjpeg($img); }
                if(substr($img,-4)==".png" || substr($img,-4)==".PNG"){$image = imagecreatefrompng($img); }
                if(substr($img,-4)==".gif" || substr($img,-4)==".GIF"){$image = imagecreatefromgif($img); }

                imagecopyresampled($miniature,$image,-$decalX,-$decalY,0,0,$dimX,$dimY,$dimension[0],$dimension[1]);
                imagejpeg($miniature,$dest,90);
                
                return true;
	}
}
?>