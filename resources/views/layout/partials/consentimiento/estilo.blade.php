<style>
    /* Cambiar las propiedades para alinearse con el generador de pdf */
    @page { 
        margin: 130px 10px; 
    }
    
    body{
        font-family: 'Noto Sans', sans-serif;
        line-height: 1;
        margin-top: 70px;
        /* background-color: aquamarine;  */
    }
    
    /* Estilos globales */
    .header { 
        position: fixed; 
        top: -100px;
        left: 0px; 
        right: 0px; 
        height: 170px; 
        margin-top: 0; /*-30px*/
        /* background-color: orchid;  */
        /* text-align: center;  */
    }
    .footer { 
        position: fixed; 
        bottom: -100; 
        left: 0px; 
        right: 0px; 
        height: 160px;
        margin-bottom: 10px;
        /* background-color: greenyellow;  */
    }

    .footer .page:after {
        content: counter(page); 
    }

    /* Saltar a nueva pagina */
    .break {
        page-break-after: always;

    }

    /* Contenido */
    .invoice-content {
        padding-right: 20px;
        padding-left: 20px;
        text-align: justify;
        text-justify: inter-word
        margin-bottom: 200px;
    }
    .invoice-content:last-child { 
        page-break-after: unset;
    }

    .content{
        /* border: 3px solid #f0f0f0; */
        /* height: 100%; */
    }
    
    /* Separador, solo borde inferior */
    .separador-bottom{
        border-style: none none solid none;
    }
    
    h1{
        font-size: 22px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h2{
        font-size: 20px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h3{
        font-size: 18px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h4{
        font-size: 16px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    h5{
        font-size: 14.8px;
        margin-top: 2px;
        margin-bottom: 2px;
    }
    p{
        font-size: 14px;
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
        margin: auto;
        white-space:nowrap;
    }
    th, td {
        border-bottom: 1px solid #ddd;
        word-break: break-all;
    }

    /* Para divisiones de 3 */
    .col-left{
        width: 25%; 
        text-align: left;
        font-size: 14px;
    }
    .col-center{
        width: 50%; 
        text-align: center;
        font-size: 14px;
    }
    .col-right{
        width: 25%; 
        text-align: right;
        font-size: 14px;
    }

    /* Para divisiones de 4 */
    .result{
        font-size:12px
    }

    .col-one{
        width: 25%; 
        text-align: left;
        
    }
    .col-two{
        width: 3%; 
        text-align: left;
        
    }
    .col-three{
        width: 40%; 
        text-align: center;
        
    }
    .col-four{
        width: 10%; 
        text-align: left;
        
    }
    .col-five{
        width: 27%; 
        text-align: left;
        
    }
    
    /* Para divisiones de dos con un div mas grande lado izquierdo con miras al centro de la hoja (segun largo)*/
    .col-resize-right{
        text-align: right;
    }
    .col-resize-left{
        text-align: left;
    }

    .columna-una{
        width: 20%;
        text-align: center;
    }
    .columna-dos{
        width: 20%;
        text-align: center;
    }
    .columna-tres{
        width: 20%;
        text-align: center;
    }
</style>