<?php  
 
class DateHelper extends AppHelper { 

    function show($datetime, $heure = false) {
        $tmstamp = strtotime($datetime);
        $jour = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
        $mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'juin', 'juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
        
        $date = "le ".$jour[date("N",$tmstamp)-1]." ".date("d",$tmstamp)." ".$mois[date("n",$tmstamp)-1]." ".date("Y",$tmstamp);
        
        if($heure == true) {
          $date.=" à ".date("H:i",$tmstamp);
        }
        
        return $date;
    }
  
    function Compare($datetime){
                
        if($datetime == "0000-00-00 00:00:00"){
            $tmstamp = time();
        }else{
            $tmstamp = strtotime($datetime);           
        }
        $now = time();
        
        $diff = $now - $tmstamp;

        $depuis = "Il y a ";
        
        $seconde    = 60;
        $heure      = 60 * 60;
        $jour       = 60 * 60 * 24;
        $semaine    = 60 * 60 * 24 * 7;
        $mois       = 60 * 60 * 24 * 7 * 30;
        $annee      = 60 * 60 * 24 * 366.5;

        if($diff < $seconde){
                
                if($diff < 2){
                    $depuis .= $diff." seconde";
                }else{
                    $depuis .= $diff." secondes";
                }
                
        }elseif($diff >= $seconde && $diff < $heure){
        
                $diff = floor($diff / $seconde);

                if($diff < 2){
                    $depuis .= $diff." minute";
                }else{
                    $depuis .= $diff." minutes";
                }
                
        }elseif($diff >= $heure && $diff < $jour){
        
                $diff = floor($diff / $heure);

                if($diff < 2){
                    $depuis .= $diff." heure";
                }else{
                    $depuis .= $diff." heures";
                }
                
        }elseif($diff >= $jour && $diff < $semaine){
            
                $diff = floor($diff/$jour);

                if($diff < 2){
                    $depuis .= $diff." jour";
                }else{
                    $depuis .= $diff." jours";
                }
    
        }elseif($diff >= $semaine && $diff < $mois){
            
                $diff = floor($diff/$semaine);
                
                if($diff < 2){
                    $depuis .= $diff." semaine";
                }else{
                    $depuis .= $diff." semaines";
                }
        
        }elseif($diff >= $mois && $diff < $annee){

                $diff = floor($diff/$mois);
                $depuis .= $diff." mois";
                
        
        }elseif($diff >= $annee){
            
                $diff = floor($diff/$annee);

                if($diff < 2){
                    $depuis .= $diff." année";
                }else{
                    $depuis .= $diff." années";
                }
        }
                
        return $depuis;
    }
    

} 
?> 