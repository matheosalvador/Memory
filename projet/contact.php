
<!DOCTYPE html>

<html lang="en"> <!-- language define to english-->
    <head>
        <meta charset="utf-8"> <!-- every character set here-->
        <link rel="stylesheet" href="assets\css\contact-scores.css">
        <title>The memory game</title>
    </head>
    <body>
        <!-- header start (start at the top)-->
        <header>
            <img class="logohead" src="assets\images\logo_memory.png" alt="logo">
                <div class="nav-container">
                    <table>
                        <thead>
                            <th><a class="spaceh" href="index.html"> Home</a></th> <!-- redirection to home page-->
                            <th><a class="spaceh" href="scores.html"> Scores</a></th> <!-- redirection to scores page-->
                            <th><button><a href="contact.html">Contact us</a></button></th> <!-- redirection to contact page-->
                        </thead>
                    </table>
                </div>
        </header>
        <!-- header end -->
    
        <span id="titlef">Our geographical locations and our headquarters</span>
        <span id="titlec">Our main location is currently in France.</span>
        <p id="titled"><img src="assets\images\perfect_map.png" width="1500px" alt="logo"></p>
        
        <div class="contactb">
    
        <!-- Réseaux sociaux -->
        <div class="contacts">
            <span class="bodyh">Follow us:</span>
                <div class="socials">
                    <a href="https://www.facebook.com/profile.php?id=61581419054379"><img src="assets\images\facebook _logo.png" alt="Facebook" class="linka"></a>
                    <a href="https://x.com/MemoryContact"><img src="assets\images\twitter_logo.png" alt="Twitter" class="linka"></a>
                    <a href="https://www.instagram.com/contact.memory.games/"><img src="assets\images\instagram_logo.png" alt="Instagram" class="linka"></a>
                    <a href="https://www.linkedin.com/in/memory-games-168488388/"><img src="assets\images\linkedin_logo.png" alt="linkdin" class="linka"></a>
                </div>
            </div>
            
            <div class="bar"></div>
            
            <!-- Téléphone -->
            <div class="contactst">
                <img class="telp" src="assets\images\tel_logo.png" alt="tel_logo">
                <span class="bodyh">+33 6 01 02 03 04</span>
            </div>
            
            <div class="bar"></div>

            <!-- Adresse -->
            <div class="contactst">
                <img id="poslogo"src="assets\images\position_logo.png" alt="position_logo">
                <span class="bodyh">23 street of Paris<br>75002 Paris</span>
            </div>
    
        </div>

        <hr id="linec">

        <h1 id="followc">Contact us!</h1>

        <from method="post" action="my-form.php">

            <p id="subfolc">If you have any questions or even if you want to be part of our team, just let us know!</p>
            <br />
            <div class="tabl">
                <div><span class="whitee">Your first name:</span><br />
                    <input class="inputbox1" type="first name" name="fisrt name" maxlength="25"/>
                </div>
                <div><span class="whitee">Your last name:</span><br/>
                    <input class="inputbox1" type="last name" name="last name" maxlength="25"/>
                </div>
            </div>
            <br />
            <div class="tablz">
                <div><span class="whitee">Your email:</span><br />
                    <input class="inputbox2" type="email" name="email" maxlength="50" />
                </div>
            </div>
            <br />
            <div class="tablz">
                <div><span class="whitee">Your message:</span><br />
                    <textarea class="inputbox3" type="message" name="message" maxlength="500" ></textarea>
                </div>
            </div>
            <br />
            <div class="tablzz">
                <input class="verify" type="submit" name="submit" />
            </div>

        <!-- start of footer (start at the bottom) -->
        <footer>
            <div class="fhead">
                <div class="tabl0">
                    <p> <img src="assets\images\logo_memory.png" alt="logo" id="logo"></p>
                    <p>Our games offer an entertaining experience<br /> and make you work on your thinking!</p>
                </div>
                <div class="tabl1">
                    <h4>Menu</h4> <!-- redirections -->
                    <a href="index.html">Home</a>
                    <a href="scores.html">Scores</a>
                    <a href="contact.html">contact</a>
                </div>
                <div class="tabl2"> <!-- sum text :> -->
                    <h4>Contact us</h4><br />
                    <span>We are at your<br />disposal for<br /> any questions.</span>
                    <br />
                    <p>contact@web.com</p>
                    <br />
                </div>
                <div id="links"> <!-- links for facebook, instagram, twitter and linkedin -->
                    <a href="https://www.facebook.com/profile.php?id=61581419054379"><img src="assets\images\facebook _logo.png" alt="Facebook" class="linka"></a>
                    <a href="https://x.com/MemoryContact"><img src="assets\images\twitter_logo.png" alt="Twitter" class="linka"></a>
                    <a href="https://www.instagram.com/contact.memory.games/"><img src="assets\images\instagram_logo.png" alt="Instagram" class="linka"></a>
                    <a href="https://www.linkedin.com/in/memory-games-168488388/"><img src="assets\images\linkedin_logo.png" alt="linkdin" class="linka"></a>
                </div>

            </div>
            <hr> <!-- line -->
            <div id="endf">
                <span>© 2025 all rights reserved</span>
            </div>
        </footer>
        <!-- end of footer -->
    </body>
</html>
