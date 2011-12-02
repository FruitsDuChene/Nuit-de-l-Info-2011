<?php
class AccessibiliteView extends AbstractView {
	public static function show() {

		$path = '/nuitinfo/Img/accessibilite';
		echo <<<END
        <div id="main">
        
            <div id="header">
                <img src="$path/logo2.jpg" />
                <h1><a href="#">Accessibilité</a></h1>
                <h2>Un site accessible par tous !</h2>
            </div>
            <div id="gallery">

                <div id="slides">
                    <div class="slide">
                        <img src="$path/logo2.jpg" />
                        <h2>Profil</h2>
                        
                        <ul>
                            <li></li>
                        </ul>
                    </div>
                    <div class="slide">
                        <h2>Formation</h2>
                        <ul>
                            <li>
                            <span class="nom_formation">  :</span> <span class="date"> Septembre 2011 (en cours)</span>
                            </li>
                        </ul>
                    </div>

                    <div class="slide">
                        <h2>Expériences professionnelles</h2>
                        <ul>
                            <li>
                            <span class="nom_xp"> Hôtesse d'accueil, Hôtesse de caisse :</span> <span class="date"> Depuis décembre 2010 </span> <span class="lieu_xp"><br/>Monoprix Victoire, Nice</span>
                            </li>
                            <li>
                            <span class="nom_xp"> Barmaid, Serveuse:</span> <span class="date"> 2006-2008 </span> <span class="lieu_xp"><br/>Restaurant le Hot Pot, Nice</span>
                            </li>

                        </ul>
                    </div>
                    <div class="slide">
                        <h2>Stages</h2>

                        <ul>
                            <li>
                            <span class="nom_stage"> Chargée de communication événementielle :</span> <span class="date"> mars à avril 2011 </span> <span class="lieu_stage"><br/>Agene Karma, La Colle-Sur-Loup</span>
                            </li>
                            <li>
                            <span class="nom_stage"> Attachée de presse, Assistante Régie, Metteur en Scène :</span> <span class="date"> avril à juin 2010 </span> <span class="lieu_xp"><br/>La compagnie de théâtre "Au Fil de Soi", Nice</span>
                            </li>

                        </ul>
                    </div>
                    <div class="slide">
                        <h2>Langues</h2>
                        <ul>
                            <li>
                            <span class="langue"> Anglais :</span> <span class="niveau"> bonne conversation </span> 
                            </li>
                            <li>
                            <span class="langue"> Chinois :</span> <span class="niveau"> notion (3 ans) </span> 
                            </li>
                            <li>
                            <span class="langue"> Japonais :</span> <span class="niveau"> notion (2 ans) </span> 
                            </li>
                        </ul>
                    </div>

                </div>

                <div id="menu">
                    <ul>
                        <li class="fbar">&nbsp;</li>
                        <li class="menuItem"><a href="">Profil</a></li>
                        <li class="menuItem"><a href="">Formation</a></li>
                        <li class="menuItem"><a href="">Expérience</a></li>
                        <li class="menuItem"><a href="">Stages</a></li>
                        <li class="menuItem"><a href="">Langues</a></li>
                    </ul>
                </div>

            </div>
END;
	}


}
?>
