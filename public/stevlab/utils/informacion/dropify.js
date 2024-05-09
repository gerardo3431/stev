$(function() {
    'use strict';
  
    $('#firma').dropify({
      messages: {
        'default': 'Arrastra y suelta un archivo aquí o haz clic',
        'replace': 'Arrastra y suelta o haz clic para reemplazar el archivo',
        'remove': 'Eliminar',
        'error': 'Lo siento, ha ocurrido un error.'
      },
      error: {
        'fileSize': 'El tamaño del archivo es demasiado grande (máximo 2MB).',
        'fileExtension': 'Solo se permiten archivos PNG.'
      },
      maxFileSize: '2M',
      allowedFormats: ['png']
    });

  });