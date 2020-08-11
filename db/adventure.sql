DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
 (
   id bigserial PRIMARY KEY,
   username varchar(25) NOT NULL UNIQUE,
   nombre varchar(255) NOT NULL,
   apellidos varchar(255) NOT NULL,
   email varchar(255) NOT NULL UNIQUE,
   rol VARCHAR(30) NOT NULL DEFAULT 'usuario',
   created_at timestamp(0) NOT NULL DEFAULT current_timestamp,
   contrasena varchar(255),
   auth_key varchar(255),
   poblacion varchar(255),
   provincia varchar(255),
   pais varchar(255)
);




DROP TABLE IF EXISTS perfil CASCADE;

CREATE TABLE perfil (
     id           bigserial      PRIMARY KEY 
   , foto_perfil  varchar(255)
   , bibliografia varchar(255)
   , valoracion   bigint 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
);

-- DROP TABLE IF EXISTS blogs CASCADE;

-- CREATE TABLE blogs (
--      id          bigserial      PRIMARY KEY 
--    , titulo      varchar(255)   NOT NULL UNIQUE
--    , descripcion varchar(255)
--    , cuerpo      text   
--    , created_at  timestamp(0)   NOT NULL DEFAULT current_timestamp
    
-- );

-- DROP TABLE IF EXISTS noticias CASCADE;

-- CREATE TABLE noticias (
--      id         bigserial      PRIMARY KEY
--    , titulo     varchar(255)  
--    , cuerpo     text
--    , entradilla varchar(255)
--    , created_at timestamp(0)   NOT NULL DEFAULT current_timestamp
-- );



-- DROP TABLE IF EXISTS comentarios CASCADE;

-- CREATE TABLE comentarios (
--      id                 bigserial      PRIMARY KEY, 
--    , user_id_comment    bigint         NOT NULL REFERENCES usuarios (id)
--    , id_comment_blog    bigint         NOT NULL REFERENCES blogs (id)
--    , id_comment_noticia bigint         NOT NULL REFERENCES noticias (id)
--    , texto              varchar(255)  
--    , created_at         timestamp(0)   NOT NULL DEFAULT current_timestamp
-- );



-- DROP TABLE IF EXISTS tablones CASCADE;

-- CREATE TABLE tablones (
--      id                 bigserial PRIMARY KEY 
--    , blog_id            bigint    NOT NULL REFERENCES blog (id)
--    , noticias_id        bigint    NOT NULL REFERENCES noticias (id)
-- );

-- DROP TABLE IF EXISTS chats CASCADE;

-- CREATE TABLE chats (
--      id                bigserial PRIMARY KEY 
--    , user_id_chat      bigint    NOT NULL REFERENCES noticias (id)
--    , emisor_response   text
--    , receptor_response text  
-- );

-- DROP TABLE IF EXISTS galerias CASCADE;

-- CREATE TABLE galerias (
--       id              bigserial PRIMARY KEY
--     , fotos
-- );

-- DROP TABLE IF EXISTS comunidades CASCADE;

-- CREATE TABLE comunidades (
--      id              bigserial      PRIMARY KEY 
--    , nombre          varchar(10)    NOT NULL UNIQUE    
--    , descripcion     text,  
--    , created_at      timestamp(0)   NOT NULL DEFAULT current_timestamp
--    , categoria       varchar(15)
--    , tablon_id       bigint         NOT NULL REFERENCES tablones (id)   
--    , participante_id bigint         NOT NULL REFERENCES usuarios (id)
--    , chat_id         bigint         NOT NULL REFERENCES chats (id)  
--    , galeria_id      bigint         NOT NULL REFERENCES galerias (id) 
-- );

-- DROP TABLE IF EXISTS creadores CASCADE;

-- CREATE TABLE creadores (
--     id              bigserial      PRIMARY KEY
--   , comunidad_id    bigint         NOT NULL REFERENCES comunidades (id)
--   , usuario_id      bigint         NOT NULL REFERENCES usuarios (id)
-- );


-- DROP TABLE IF EXISTS respuestas CASCADE;

-- CREATE TABLE respuestas (
--      id               bigserial     PRIMARY KEY
--    , user_id_response bigint        NOT NULL REFERENCES usuarios (id)
--    , texto            varchar(255)    
-- );



INSERT INTO usuarios (username, nombre, apellidos, email, rol, created_at, contrasena, poblacion, provincia, pais)
VALUES ('admin', 'admin', 'admin', 'adventure@gmail.com', 'administrador', '11/08/2020', crypt('admin', gen_salt('bf', 10)), 'Sanlúcar de Barrameda', 'Cádiz' , 'España');


INSERT INTO perfil (foto_perfil, bibliografia, valoracion, usuario_id)
VALUES ('foto.jpg', 'Soy un administrador de Adventure', 5, 1);