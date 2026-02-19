<?php
    session_start();
    $usuario= $_SESSION["datosUsuarioOrdenar"];
    if($usuario!=""){
         header("location: inicio.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varadero</title>

    <!-- CSS -->
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="index.css">

    <link rel="shortcut icon" type='image/x-icon' href='img/varadero_logo.png'>
</head>
<body>

    <section>
        <div class="section_derecho bd">
           <img src="img/varadero_logo.png" alt="">
           
        </div>

        <div class="section_izquierda bd">

            <div class="izq_logo">
                <!-- <img id="img1_pc" src="img/logo.png" alt=""> -->
                <img id="img1_cel" src="img/varadero_logo.png" alt="">
            </div>
            <div class="izq_mensaje bd">
                
                <h3>Ordenar</h3>
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
                    // console.log(data);
                    if(data=="success"){
                         location.href="orden1/orden.php";
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
        if(passwordField.type=="password"){
            passwordField.type="text";
            toggleBtn.classList.add("active");
        }else{
            passwordField.type="password";
            toggleBtn.classList.remove("active");
        }
    }
</script>