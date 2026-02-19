<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varadero | Iniciar sesión</title>
    <link rel="shortcut icon" type='image/x-icon' href='../img/varadero_logo.png'>

    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="spinner.css">
   
    <script src='../jquery/jquery-3.5.1.min.js'></script>

    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">
    <!-- BOOSTRAP -->
    <!-- <link rel="stylesheet" href="boostrap/bootstrap.min.css"> -->

</head>
<body>
    <div class="login-container bd">
        <div class="logo"><img src="../img/varadero_logo.png" alt=""></div>
       
        <div class='titulos'>
            <h1>Iniciar Sesión</h1>
            <p>Accede a tu panel de administración</p>
        </div>
        
        
        <form id="loginForm">
            <div class="form-group bd">
                <label for="nombre"><i class="fa-solid fa-user"></i> Nombre usuario</label>
                <input type="text" id="nombre" name='nombre' placeholder="Nombre usuario">
            </div>

            <div class="form-group bd">
                <div class="password-container bd">
                    <label for="password"><i class="fa-solid fa-lock"></i>  Contraseña</label>
                </div>
                <input type="password" id="password" name='password' placeholder="••••••••••••"><i class="fas fa-eye"></i>
            </div>

            <div class='fields-messageLogin mensajeError bd ' style='display:none'>
                <i class="fa-solid fa-circle-exclamation"></i><p>Usuario o contraseña incorrectos</p>
            </div>

            <button id='btningresar' class="btn">
                <span class="btn-spinner"></span>
                <span class="btn-text">Entrar <i class="fa-solid fa-arrow-right"></i></span>
            </button>

        </form>

        <p class="signup-link">
            Derechos reservados © 2025</a>
        </p>

    </div>

    <div class='text-version'>
        <p>Versión 3.0</p>
    </div>


    <div class='decoration flex-center'>
        <img src="../img/index.svg" alt="Decorative illustration">
    </div>


    <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
        <div class="mensajeDispositivos">
            <img src="../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>




</body>
</html>

<script>


    /*===============================================
    INICIAR SESIÓN
    ================================================*/

    const formulario = document.querySelector("#loginForm");
        continueBtn= formulario.querySelector("#btningresar"),
        errorMessage= formulario.querySelector('.fields-messageLogin');

         formulario.onsubmit = (e)=>{
            e.preventDefault();
        }

        continueBtn.onclick=()=>{
            

            //SPINNER
            continueBtn.classList.add('is-loading');
            continueBtn.querySelector('.btn-text').innerHTM =`Entrando...`;
            continueBtn.disabled = true;


              let xhr=new XMLHttpRequest();
                xhr.open("POST", "login.php", true);
                xhr.onload=()=>{
                    if(xhr.readyState===XMLHttpRequest.DONE){
                        if(xhr.status===200){
                            let data=xhr.response;
                            console.log(data);
                            
                            if(data=="success"){
                                window.location.href = 'inicio/inicio.php';
                            
                            }else{
                                errorMessage.innerHTML=data;
                                errorMessage.style.display="block"; 
                            }

                           continueBtn.classList.remove('is-loading');
                            continueBtn.querySelector('.btn-text').innerHTM = `Registrar <i class="fa-solid fa-arrow-right"></i>`;
                            continueBtn.disabled = false;
                        }
                    }
                }
                //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
                const formData=new FormData(formulario);
            
                xhr.send(formData);
             }


    
    
    
    
    /*===============================================
    MOSTRAR CONTRASEÑA
    ================================================*/
    const passwordField=document.querySelector("#password");
    toggleBtn=document.querySelector(".form-group .fa-eye");

    toggleBtn.onclick=()=>{
        
        if(passwordField.type=="password"){
            passwordField.type="text";
            toggleBtn.classList.add("active");
        }else{
            passwordField.type="password";
            toggleBtn.classList.remove("active");
        }
    }


</script>