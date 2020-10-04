

-- CREATE TABLE imagenes (
--       id              bigserial PRIMARY KEY
--     , fotos           text      
-- );
-- DROP TABLE IF EXISTS galerias CASCADE;

-- CREATE TABLE galerias (
--       id              bigserial PRIMARY KEY
--     , fotos           text      
-- );


DROP TABLE IF EXISTS comunidades CASCADE;

CREATE TABLE comunidades (
    id              bigserial      PRIMARY KEY 
  , nombre          varchar(255)    NOT NULL UNIQUE    
  , descripcion     text  
  , created_at      timestamp(0)   NOT NULL DEFAULT current_timestamp
 -- , galeria_id      bigint         REFERENCES galerias (id)
);


DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
 (
    id bigserial PRIMARY KEY
  , username varchar(25) NOT NULL UNIQUE
  , nombre varchar(255) NOT NULL
  , apellidos varchar(255) NOT NULL
  , email varchar(255) NOT NULL UNIQUE
  , rol varchar(30) NOT NULL DEFAULT 'estandar'
  , created_at timestamp(0) NOT NULL DEFAULT current_timestamp
  , contrasena varchar(255)
  , auth_key varchar(255)
  , poblacion varchar(255)
  , provincia varchar(255)
  , pais varchar(255)
);

DROP TABLE IF EXISTS perfil CASCADE;

CREATE TABLE perfil (
     id           bigserial      PRIMARY KEY 
   , foto_perfil  varchar(255)
   , bibliografia varchar(255)
   , valoracion   bigint 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
);

DROP TABLE IF EXISTS blogs CASCADE;

CREATE TABLE blogs (
     id           bigserial      PRIMARY KEY 
   , titulo       varchar(255)   NOT NULL UNIQUE
-- , imagen       text
   , descripcion  varchar(255)
   , cuerpo       text   
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id)
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);

 -- DROP TABLE IF EXISTS blogs_destacados CASCADE;

-- CREATE TABLE blogs_destacados (
--      id           bigserial      PRIMARY KEY
--    , titulo       varchar(255)   
--  --, miniatura    text
--    , likes        bigint
--    , comments     bigint
--    , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
-- );



DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios (
     id                 bigserial      PRIMARY KEY 
   , user_id_comment    bigint         NOT NULL REFERENCES usuarios (id)
   , id_comment_blog    bigint         NOT NULL REFERENCES blogs (id)
   , texto              varchar(255)  
   , created_at         timestamp(0)   NOT NULL DEFAULT current_timestamp
);

-- DROP TABLE IF EXISTS respuestas CASCADE;

-- CREATE TABLE respuestas (
--      id               bigserial     PRIMARY KEY
--    , user_id_response bigint        NOT NULL REFERENCES usuarios (id)
--    , texto            varchar(255)    
-- );



DROP TABLE IF EXISTS usuario_comunidad CASCADE;

CREATE TABLE usuario_comunidad (
     id           bigserial      PRIMARY KEY 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
   , creador      boolean        NOT NULL
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id)
);



-- DROP TABLE IF EXISTS chats CASCADE;

-- CREATE TABLE chats (
--      id                bigserial PRIMARY KEY 
--    , user_id_chat      bigint    NOT NULL REFERENCES noticias (id)
--    , emisor_response   text
--    , receptor_response text  
-- );








INSERT INTO usuarios (username, nombre, apellidos, email, rol, contrasena, poblacion, provincia, pais)
VALUES ('admin', 'admin', 'admin', 'adventure@gmail.com', 'administrador', crypt('admin', gen_salt('bf', 10)), 'Sanlúcar de Barrameda', 'Cádiz' , 'España');


INSERT INTO perfil (foto_perfil, bibliografia, valoracion, usuario_id)
VALUES ('foto.jpg', 'Soy un administrador de Adventure', 5, 1);



-- INSERT INTO galerias (fotos)  
-- VALUES ('foto.png');


INSERT INTO comunidades (nombre, descripcion)
VALUES ('Escribir es para todos', 
        'Estaís todos invitados formar parte de la comunidad para escritores animaté 
         y comparte tus ideas a con todos nosotros');

INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id)
VALUES ('Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1);


INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id)
VALUES ('1Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1);

INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id)
VALUES ('2Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1);


INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id)
VALUES ('3Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1);




INSERT INTO comentarios (user_id_comment, id_comment_blog, texto)
VALUES (1, 1, 'Es una maravilla, me encanta'); 

INSERT INTO usuario_comunidad (usuario_id, creador, comunidad_id)
VALUES (1, '1', 1);         




-- INSERT INTO chats (user_id_chat, emisor_response, receptor_response)
-- VALUES (1, "Hola, Soy el administrador", "Hola, soy un usuario")

