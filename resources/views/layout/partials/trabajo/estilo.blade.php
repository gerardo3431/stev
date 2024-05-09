<style>
    /* Cambiar las propiedades para alinearse con el generador de pdf */
    @page { 
        margin: 165px 10px; 
    }
    
    body{
        font-family: 'Noto Sans', sans-serif;
        line-height: 1;
        margin-top: 0px;
        margin-bottom: -50px;
        margin-left: 15px;
        margin-right: 15px;
        /* background-color: cadetblue */
    }
    
    #image {
        top: -155px;
        position: fixed;
        height: 2200px;
        width: 800px;
        z-index: -9999;
        
        background-image: url({{$membrete}});
        background-repeat: no-repeat;
        background-size: 100%;
    }
    
    /* Estilos globales */
    .header { 
        position: fixed; 
        top: -165px;
        left: 25px; 
        right: 25px; 
        height: 160px; 
        margin-top: 0; /*-30px*/
        /* background-color: coral; */
    }
    .footer { 
        position: fixed; 
        bottom: -165px; 
        left: 25px; 
        right: 25px; 
        height: 110px; 
        /* background-color: blueviolet; */
        /* background-color: cornflowerblue; */
    }
    .footer .page:after {
        content: counter(page); 
    }

    /* Saltar a nueva pagina */
    .break {
        page-break-after: avoid;
    }

    /* Contenido */
    .invoice-content {
        border-radius: 4px;
        padding-bottom: 10px;
        /* padding-right: 20px; */
        /* padding-left: 20px; */
        text-align: justify;
        text-justify: inter-word;
        line-height: 0.5;
        display: grid;
        grid-template: auto / auto auto;
        /* grid-template: 150px / auto auto; */

    }
    /* Separador, solo borde inferior */
    .separador-bottom{
        border-style: none none solid none;
    }
    /* .separador-resultados{
        border:  1px solid rgba(158, 156, 156, 0.495);
    } */
    
    h1{
        font-size: 18px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h2{
        font-size: 16px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h3{
        font-size: 14px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h4{
        font-size: 12px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h5{
        font-size: 10.8px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    p{
        font-size: 10px;
    }
    /* strong{
        font-size: 13px;
    } */
    .align-center{
        text-align: center;
    }
    
    
    /* tabla */
    table{
        width: 100%;
        max-width: 100%;
        margin: auto;
        white-space:nowrap;
    }
    th, td {
        /* border-bottom: 1px solid #ddd; */
        word-break: break-all;
        text-align: justify
    }

    /* Para divisiones de 3 */
    .col-left{
        width: 25%; 
        max-width: 25%; 
        text-align: left;
        font-size: 11px;
    }
    .col-center{
        width: 50%; 
        max-width: 50%; 
        text-align: center;
        font-size: 11px;
    }
    .col-right{
        width: 25%; 
        max-width: 25%; 
        text-align: right;
        font-size: 11px;
    }

    /* Para divisiones de 4 */
    .result{
        font-size:10px
    }

    .col-one{
        width: 25%; 
        max-width: 25%; 
        text-align: left;
        font-size: 11px;
    }
    .col-two{
        width: 3%; 
        text-align: left;
        font-size: 11px;
    }
    .col-three{
        width: 40%; 
        max-width: 40%; 
        text-align: left;
        font-size: 11px;
    }
    .col-four{
        width: 10%; 
        max-width: 10%; 
        text-align: left;
        font-size: 11px;
    }
    .col-five{
        width: 27%; 
        max-width: 27%; 
        text-align: left;
        font-size: 11px;
    }
    
    /* Para divisiones de dos con un div mas grande lado izquierdo con miras al centro de la hoja (segun largo)*/
    .col-resize-right{
        text-align: right;
    }
    .col-resize-left{
        text-align: left;
    }

    .columna-una{
        width: 25%;
        max-width: 25%;
        text-align: left;
    }
    .columna-dos{
        width: 75%;
        max-width: 75%;
        text-align: left;
    }
    .grid-container {
        /* display: grid; */
        /* width: 100%; */
        /* max-width: 100%; */

        /* grid-template: 150px / auto auto; */

        /* grid-template:  "a b" auto
                        "a b" auto
                        "a b" auto ; */

        /* grid-template: auto / auto auto; */

        /* grid-template-rows: 100px 100px; */

        /* grid-template-columns: 100px auto; */
    }

</style>