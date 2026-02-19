<?php
    session_start();
    $usuario= $_SESSION["datosUsuarioCaja"]["usuario"];
    if($usuario!=""){
         header("location: inicio.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vardero | Caja</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="index.css">

    <link rel="shortcut icon" type='image/x-icon' href='../img/varadero_logo.png'>
</head>
<body>

    <nav class="nav">
        <div class="contenedor_nav">
            <a href="../index.html"><i class="fa-solid fa-border-all"></i>Ordenar</a>
            <a href="../cocina/index.html"><i class="fa-solid fa-bowl-rice"></i>Cocina</a>
            <a href="../barra/index.html"><i class="fa-solid fa-wine-bottle"></i>Barra</a>
            <a href="../admin/index.html"><i class="fa-solid fa-chart-simple"></i>Admin</a>
        </div>
    </nav>

    <section>
        <div class="section_derecho bd">
           <img src="../img/varadero_logo.png" alt="">
           
        </div>

        <div class="section_izquierda bd">

            <div class="izq_logo">
                <!-- <img id="img1_pc" src="img/logo.png" alt=""> -->
              
            </div>
            <div class="izq_mensaje bd">
                
                <h3>Caja</h3>
                <br>
                <h2>Bienvenido</h2>
                <p>Ingresa tu usuario y contraseña para entrar.</p>
            </div>
            <div class="izq_formulario bd">
                <form action="login.php">
                    <table>
                      
                        <tr>
                            <td class="error-txt"></td>
                        </tr>
                        <tr>
                            <td>
                                <label for=""><i class="fa-solid fa-user"></i>Usuario</label>
                                <input type="text" class="form-control w-100 text-center" name="usuario" placeholder="Usuario" required>
                            </td>
                        </tr>
                       
                        <tr>
                            <td>
                                <div class="field">
                                    <label for=""><i class="fa-solid fa-lock"></i>Contraseña</label>
                                    <input type="password" class="form-control w-100 text-center" name="password" placeholder="Ingresa tu contraseña" required><i class="fas fa-eye"></i>
                                </div>
                                
                            </td>
                        </tr>

                        <tr>
                            <td class="button"><input type="submit" value="Entrar"></td>
                        </tr>
                    </table>
                </form>
            </div>

            

            <p class="copy">Derechos reservados © 2024 Alonso Gomez</p>

        </div>

    </section>


      <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
      <div class="mensajeDispositivos">
            <img src="../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>

    
</body>
</html>
<script>
    const form = document.querySelector(".izq_formulario form"),
    continueBtn= form.querySelector(".button input"),
    errorText= form.querySelector(".error-txt");

    form.onsubmit = (e)=>{
        e.preventDefault();
    }


    continueBtn.onclick=()=>{
        
        let xhr=new XMLHttpRequest();
        xhr.open("POST", "login.php", true);
        xhr.onload=()=>{
            if(xhr.readyState===XMLHttpRequest.DONE){
                if(xhr.status===200){
                    let data=xhr.response;
                     
                    if(data=="success"){
                         location.href="inicio.php";
                    }else{  
                        errorText.innerHTML=data;
                        errorText.style.display="block"; 
                    }
                }
            }
        }
        //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
        const formData=new FormData(form);
        xhr.send(formData);

    }

    ///////////////////////////////////////////////////////////////
    //MOSTRAR CONTRASEÑA
    const passwordField=document.querySelector(".izq_formulario input[type='password']");
    toggleBtn=document.querySelector(".izq_formulario .field .fa-eye");


    toggleBtn.onclick=()=>{
        console.log("hola");
        if(passwordField.type=="password"){
            passwordField.type="text";
            toggleBtn.classList.add("active");
        }else{
            passwordField.type="password";
            toggleBtn.classList.remove("active");
        }
    }
</script>