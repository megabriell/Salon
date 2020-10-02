/*  Cuando busca una tabla con caracteres acentuados, puede ser frustrante tener
  una entrada como _Zurich_ no coincide con _Zürich_ en la tabla (`u! == ü`). Esta
  el complemento de búsqueda basado en tipo reemplaza el formateador de cadenas incorporado en
  DataTables con una función que eliminará reemplaza los caracteres acentuados
  con sus contrapartes sin acento para un filtrado rápido y fácil.
 
  Tenga en cuenta que con los caracteres acentuados que se reemplazan, una entrada de búsqueda usando
  los caracteres acentuados ya no coincidirán. El segundo ejemplo a continuación muestra
  cómo la función se puede usar para eliminar acentos de la entrada de búsqueda también,
  para mitigar este problema
 
   @summary Reemplaza los caracteres acentuados con contrapartes sin acentos
   @name Accent neutraliza
   @author Allan Jardine
 
   @example
     $(document).ready(function() {
         $('#example').dataTable();
     } );
 
   @example
     $(document).ready(function() {
         var table = $('#example').dataTable();
 
         // Eliminar el carácter acentuado de la entrada de búsqueda también
         $('#myInput').keyup( function () {
           table
             .search(
               jQuery.fn.DataTable.ext.type.search.string( this.value )
             )
             .draw()
         } );
     } );
*/

jQuery.fn.DataTable.ext.type.search.string = function ( data ) {
    return ! data ?
        '' :
        typeof data === 'string' ?
            data
                .replace( /έ/g, 'ε' )
                .replace( /[ύϋΰ]/g, 'υ' )
                .replace( /ό/g, 'ο' )
                .replace( /ώ/g, 'ω' )
                .replace( /ά/g, 'α' )
                .replace( /[ίϊΐ]/g, 'ι' )
                .replace( /ή/g, 'η' )
                .replace( /\n/g, ' ' )
                .replace( /á/g, 'a' )
                .replace( /é/g, 'e' )
                .replace( /í/g, 'i' )
                .replace( /ó/g, 'o' )
                .replace( /ú/g, 'u' )
                .replace( /ê/g, 'e' )
                .replace( /î/g, 'i' )
                .replace( /ô/g, 'o' )
                .replace( /è/g, 'e' )
                .replace( /ï/g, 'i' )
                .replace( /ü/g, 'u' )
                .replace( /ã/g, 'a' )
                .replace( /õ/g, 'o' )
                .replace( /ç/g, 'c' )
                .replace( /ì/g, 'i' ) :
            data;
};