# Decisiones adoptadas

He tenido que tomar ciertas decisiones a la hora de crear la base de datos, como implementar el Perfil en la tabla del usuario en vez de realizar una tabla Perfiles. 

Buscando información en diferentes fuentes sería posible crear una tabla a parte para crear la tabla de Perfiles teniendo en cuenta si este va a contener muchas columnas nulas a parte de evitar lo que se conoce como "clase divina", es decir, que una sola tabla contenga muchas columnas convirtiendola en una tabla muy importante o que viene siendo un objeto demasiado poderoso convirtiendose en un anti-patrón que va totamente en contra de la programación estructurada que consiste en dividir el problema en diferentes partes. 


Por otra parte, la tabla de comentarios es utilizada para mostrar los comentarios en el Perfil y en los Blogs. He creido conveniente realizarlo de esta forma ya que no creía necesario crear dos tablas para la misma funcionalidad.