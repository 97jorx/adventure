

-- CREATE TABLE imagenes (
--       id              bigserial PRIMARY KEY
--     , fotos           text      
-- );
-- DROP TABLE IF EXISTS galerias CASCADE;

-- CREATE TABLE galerias (
--       id              bigserial PRIMARY KEY
--     , fotos           text      
-- );

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
  , fecha_nac timestamp(0) NOT NULL
  , contrasena varchar(255)
  , auth_key varchar(255)
  , poblacion varchar(255)
  , provincia varchar(255)
  , pais varchar(255)
  , foto_perfil  varchar(255)
  , bibliografia varchar(255)
  , valoracion   bigint 
);

-- DROP TABLE IF EXISTS categorias CASCADE;


-- CREATE TABLE categorias (
--      id           bigserial    PRIMARY KEY
--      categoria    varchar(25)  NOT NULL
--);



DROP TABLE IF EXISTS comunidades CASCADE;

CREATE TABLE comunidades (
    id              bigserial      PRIMARY KEY 
   , denom           varchar(255)   NOT NULL UNIQUE    
   , descripcion     text  
   , created_at      timestamp(0)   NOT NULL DEFAULT current_timestamp
   , propietario     bigint         NOT NULL REFERENCES usuarios (id)
-- , categoria_id    bigint         REFERENCES categorias (id)
-- , galeria_id      bigint         REFERENCES galerias (id)
);



DROP TABLE IF EXISTS blogs CASCADE;

CREATE TABLE blogs (
     id           bigserial      PRIMARY KEY 
   , titulo       varchar(255)   NOT NULL UNIQUE
-- , imagen       text
   , descripcion  varchar(255)
   , cuerpo       text   
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id)
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);

 -- DROP TABLE IF EXISTS blogs_destacados CASCADE;

-- CREATE TABLE blogs_destacados (
--      id           bigserial      PRIMARY KEY
--    , titulo       varchar(255)   
--    , miniatura    text
--    , likes        bigint
--    , total_comments     bigint
--    , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
-- );





-- TODO RESPONDER COMENTARIOS.

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios (
     id                 bigserial      PRIMARY KEY 
   , user_id_comment    bigint         NOT NULL REFERENCES usuarios (id)
   , id_comment_blog    bigint         NOT NULL REFERENCES blogs (id)
   , texto              varchar(255)  
   , created_at         timestamp(0)   NOT NULL DEFAULT current_timestamp
);




-- DROP TABLE IF EXISTS seguidores CASCADE;

-- CREATE TABLE seguidores (
--      id               bigserial     PRIMARY KEY
--    , usuario_id       bigint        NOT NULL REFERENCES usuarios (id)
--    , seguidor         bigint        NOT NULL REFERENCES usuarios (id)
-- );


-- DROP TABLE IF EXISTS bloqueados CASCADE;

-- CREATE TABLE bloqueados (
--      id               bigserial     PRIMARY KEY
--    , usuario_id       bigint        NOT NULL REFERENCES usuarios (id)
--    , bloqueado        bigint        NOT NULL REFERENCES usuarios (id)
-- );

DROP TABLE IF EXISTS integrantes CASCADE;


CREATE TABLE integrantes (
     id           bigserial      PRIMARY KEY 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id)
);



-- DROP TABLE IF EXISTS chats CASCADE;

-- CREATE TABLE chats (
--      id                bigserial PRIMARY KEY 
--    , user_id_chat      bigint    NOT NULL REFERENCES noticias (id)
--    , emisor_response   text
--    , receptor_response text  
-- );








INSERT INTO usuarios (username, nombre, apellidos, email, rol, fecha_nac, contrasena, poblacion, provincia, pais, foto_perfil, bibliografia, valoracion)
VALUES (
         'admin', 'admin', 'admin', 
         'adventure@gmail.com', 'administrador', '1978-06-22',
          crypt('admin', gen_salt('bf', 10)), 
         'Sanlúcar de Barrameda', 'Cádiz' ,'España', 
         'foto.jpg', 'Soy un administrador de Adventure', 5
        );

INSERT INTO comunidades (denom, descripcion, propietario)
VALUES ('Escribir es para todos', 
        'Estaís todos invitados formar parte de la comunidad para escritores animaté 
         y comparte tus ideas a con todos nosotros', 1);

INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id, usuario_id)
VALUES ('Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1);


INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id, usuario_id )
VALUES ('1Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1);

INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id, usuario_id)
VALUES ('2Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1);


INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id,  usuario_id)
VALUES ('3Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
        'Lo mejor que me he leído hasta ahora de Shakespeare: 
        conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
        La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
        Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
        A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
        Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1);




INSERT INTO comentarios (user_id_comment, id_comment_blog, texto)
VALUES (1, 1, 'Es una maravilla, me encanta'); 

INSERT INTO integrantes (usuario_id, comunidad_id)
VALUES (1, 1);         



