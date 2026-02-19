<nav class="sidebar bd">
            <div class="logo bd"><img src="../../img/varadero_logo.png" alt=""></div>
            <ul class='bd'>

                <?php

                    
                    if($role=="admin"){
                        echo "<li id='menu-caja'><a href='inicio.php?caja'><i class='fa-solid fa-cash-register'></i></a></li>
                            <li id='menu-historial'><a href='inicio.php?historial'><i class='fa-solid fa-clock-rotate-left'></i></a></li>
                            <li id='menu-gastos'><a href='inicio.php?gastos'><i class='fa-solid fa-coins'></i></a></li>
                            <li id='menu-productos'><a href='inicio.php?productos'><i class='fa-solid fa-fish'></i></a></li>
                            <li id='menu-facturas'><a href='inicio.php?facturas'><i class='fa-solid fa-file-invoice-dollar'></i></a></li>
                            <li id='menu-cortesias'><a href='inicio.php?cortesias'><i class='fa-solid fa-gift'></i></a></li>
                            <li id='menu-eliminados'><a href='inicio.php?eliminados'><i class='fa-solid fa-trash'></i></a></li>
                            <li id='menu-usuarios'><a href='inicio.php?usuarios'><i class='fa-solid fa-user'></i></a></li>
                            <li id='menu-estadisticas'><a href='inicio.php?estadisticas'><i class='fa-solid fa-chart-simple'></i></a></li>";
                            
                    }else{
                       echo "<li id='menu-caja'><a href='inicio.php?caja'><i class='fa-solid fa-cash-register'></i></a></li>
                            <li id='menu-historial'><a href='inicio.php?historial'><i class='fa-solid fa-clock-rotate-left'></i></a></li>
                            <li id='menu-gastos'><a href='inicio.php?gastos'><i class='fa-solid fa-coins'></i></a></li>
                            <li id='menu-productos'><a href='inicio.php?productos'><i class='fa-solid fa-fish'></i></a></li>
                            <li id='menu-facturas'><a href='inicio.php?facturas'><i class='fa-solid fa-file-invoice-dollar'></i></a></li>
                            <li id='menu-cortesias'><a href='inicio.php?cortesias'><i class='fa-solid fa-gift'></i></a></li>";
                    }
                ?>

                
            </ul>
    </nav>

    <script>
        let menu=document.querySelectorAll(".sidebar ul li");
                   
            menu.forEach(element => {
                    
                element.addEventListener('click',()=>{

                    limpiarLinksMenu();
                    element.classList.add("active");
                })
            });

            function limpiarLinksMenu(){
                //REMOVE ACTIVE
                for(m=0; m<menu.length; m++){
                        let mparent=menu[m];
                        mparent.classList.remove("active");
                    }
            }

    </script>