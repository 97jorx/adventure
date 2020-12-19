

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
     id           bigserial      PRIMARY KEY
   , username     varchar(25)    NOT NULL UNIQUE
   , alias        varchar(35)    NOT NULL UNIQUE
   , nombre       varchar(255)   NOT NULL
   , apellidos    varchar(255)   NOT NULL
   , email        varchar(255)   NOT NULL UNIQUE
   , rol          varchar(30)    NOT NULL DEFAULT 'estandar'
   , estado_id    bigint         REFERENCES estados (id) DEFAULT 4
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
   , fecha_nac    timestamp(0)   NOT NULL
   , contrasena   varchar(255)   NOT NULL
   , auth_key     varchar(255)
   , poblacion    varchar(255)
   , provincia    varchar(255)
   , pais         varchar(255)
   , foto_perfil  varchar(255)
   , bibliografia varchar(255)
);

DROP TABLE IF EXISTS estados CASCADE;
CREATE TABLE estados (
     id          bigserial      PRIMARY KEY 
   , estado      text           NOT NULL
);


-- TABLA DE LAS COMUNIDADES
DROP TABLE IF EXISTS comunidades CASCADE;
CREATE TABLE comunidades (
     id           bigserial      PRIMARY KEY 
   , denom        varchar(255)   NOT NULL UNIQUE    
   , descripcion  text           NOT NULL    
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
   , propietario  bigint         NOT NULL REFERENCES usuarios (id)
);


-- TABLA DE LOS BLOGS
DROP TABLE IF EXISTS blogs CASCADE;
CREATE TABLE blogs (
     id           bigserial      PRIMARY KEY 
   , titulo       varchar(255)   NOT NULL UNIQUE
-- , imagen       text
   , descripcion  varchar(255)   NOT NULL
   , cuerpo       text           NOT NULL
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id) ON DELETE CASCADE ON UPDATE CASCADE 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);



DROP TABLE IF EXISTS notificaciones CASCADE;
CREATE TABLE notificaciones (
     id           bigserial      PRIMARY KEY
   , usuario_id   bigint         NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE
   , mensaje      bigint         NOT NULL
   , leido        boolean        DEFAULT false
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);


DROP TABLE IF EXISTS comentarios CASCADE;
CREATE TABLE comentarios (
     id          bigserial      PRIMARY KEY 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
   , blog_id      bigint         REFERENCES blogs (id)
   , reply_id     bigint         NOT NULL REFERENCES comentarios (id) 
   , texto        varchar(255)   NOT NULL
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);


-- TABLA DE LOS USUARIOS BLOQUEADOS POR COMUNIDADES
DROP TABLE IF EXISTS bloqcomunidades CASCADE;
CREATE TABLE bloqcomunidades (
     id           bigserial      PRIMARY KEY
   , bloqueado    bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id) ON DELETE CASCADE ON UPDATE CASCADE
);


-- NOTAS DE CADA BLOG Y NOTA MEDIA PARA EL USUARIO
DROP TABLE IF EXISTS notas CASCADE;
CREATE TABLE notas (
     id           bigserial      PRIMARY KEY
   , nota         integer        DEFAULT 0
   , blog_id      bigint         NOT NULL REFERENCES blogs (id) ON DELETE CASCADE ON UPDATE CASCADE
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);

-- TABLA DE LOS BLOGS FAVORITOS DE CADA USUARIO
DROP TABLE IF EXISTS favblogs CASCADE;
CREATE TABLE favblogs (
     id           bigserial      PRIMARY KEY
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , blog_id      bigint         NOT NULL REFERENCES blogs (id) ON DELETE CASCADE ON UPDATE CASCADE
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp        
);


-- TABLA DE LAS COMUNIDADES FAVORITAS DE CADA USUARIO
DROP TABLE IF EXISTS favcomunidades CASCADE;
CREATE TABLE favcomunidades (
     id           bigserial      PRIMARY KEY 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id) ON DELETE CASCADE ON UPDATE CASCADE     
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);


-- TABLA DE LAS VISITAS DE CADA BLOG 
DROP TABLE IF EXISTS visitas CASCADE;
CREATE TABLE visitas (
     id           bigserial      PRIMARY KEY
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , blog_id      bigint         NOT NULL REFERENCES blogs (id) ON DELETE CASCADE ON UPDATE CASCADE
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp        
);

-- TABLA DE LOS SEGUIDORES 
DROP TABLE IF EXISTS seguidores CASCADE;
CREATE TABLE seguidores (
     id           bigserial      PRIMARY KEY
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , seguidor     bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- TABLA DE LOS BLOQUEOS A USUARIOS
DROP TABLE IF EXISTS bloqueados CASCADE;
CREATE TABLE bloqueados (
     id           bigserial      PRIMARY KEY
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , bloqueado    bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS integrantes CASCADE;
CREATE TABLE integrantes (
     id           bigserial      PRIMARY KEY 
   , usuario_id   bigint         NOT NULL REFERENCES usuarios (id) ON DELETE CASCADE ON UPDATE CASCADE
   , comunidad_id bigint         NOT NULL REFERENCES comunidades (id) ON DELETE CASCADE ON UPDATE CASCADE
   , created_at   timestamp(0)   NOT NULL DEFAULT current_timestamp
);


DROP TABLE IF EXISTS session CASCADE;
CREATE TABLE session
(
    id CHAR(40) NOT NULL PRIMARY KEY,
    expire INTEGER,
    data BLOB,
    user_id INTEGER,
    last_write TIMESTAMP
)


 -- DROP TABLE IF EXISTS blogs_destacados CASCADE;

-- CREATE TABLE blogs_destacados (
--    id             bigserial      PRIMARY KEY
-- ,  titulo         varchar(255)   
-- ,  miniatura      text
-- ,  likes          bigint
-- ,  total_comments bigint
-- );

-- TODO RESPONDER COMENTARIOS.


-- DROP TABLE IF EXISTS chats CASCADE;

-- CREATE TABLE chats (
--    id                bigserial PRIMARY KEY 
--  , user_id_chat      bigint    NOT NULL REFERENCES noticias (id)
--  , emisor_response   text
--  , receptor_response text  
-- );




INSERT INTO usuarios (username, nombre, alias,apellidos, email, rol, fecha_nac, contrasena, poblacion, provincia, pais, foto_perfil, bibliografia)
VALUES (
         'admin', 'admin', 'admin', 'admin',
         'adventure@gmail.com', 'administrador', '1978-06-22',
          crypt('admin', gen_salt('bf', 10)), 
         'Sanlúcar de Barrameda', 'Cádiz' ,'España', 
         'foto.jpg', 'Soy un administrador de Adventure'
        );

INSERT INTO usuarios (username, nombre, alias, apellidos, email, rol, fecha_nac, contrasena)
VALUES ('Usuario1',  'Usuario1',  'Neptuno', 'Usuario1', 'usuario1@gmail.com',  'estandar', '1978-06-22', crypt('usuario1',  gen_salt('bf', 10))),
       ('Usuario2',  'Usuario2',  'Jupiter', 'Usuario2', 'usuario2@gmail.com',  'estandar', '1978-06-22', crypt('usuario2',  gen_salt('bf', 10))), 
       ('Usuario3',  'Usuario3',  'Pepito',  'Usuario3', 'usuario3@gmail.com',  'estandar', '1978-06-22', crypt('usuario3',  gen_salt('bf', 10))),
       ('Usuario4',  'Usuario4',  'Khaos',   'Usuario4', 'usuario4@gmail.com',  'estandar', '1978-06-22', crypt('usuario4',  gen_salt('bf', 10))),
       ('Usuario5',  'Usuario5',  'Caotico', 'Usuario5', 'usuario5@gmail.com',  'estandar', '1978-06-22', crypt('usuario5',  gen_salt('bf', 10))),
       ('Usuario6',  'Usuario6',  'Drogoz',  'Usuario6', 'usuario6@gmail.com',  'estandar', '1978-06-22', crypt('usuario6',  gen_salt('bf', 10))),
       ('Usuario7',  'Usuario1',  'Example', 'Usuario7', 'usuario7@gmail.com',  'estandar', '1978-06-22', crypt('usuario7',  gen_salt('bf', 10))),
       ('Usuario8',  'Usuario8',  'Burbuja', 'Usuario8', 'usuario8@gmail.com',  'estandar', '1978-06-22', crypt('usuario8',  gen_salt('bf', 10))),
       ('Usuario9',  'Usuario9',  'Gato',    'Usuario9', 'usuario9@gmail.com',  'estandar', '1978-06-22', crypt('usuario9',  gen_salt('bf', 10))),
       ('Usuario10', 'Usuario10', 'Luna',    'Usuario10','usuario10@gmail.com', 'estandar', '1978-06-22', crypt('usuario10', gen_salt('bf', 10))),
       ('Usuario11', 'Usuario11', 'Sol',     'Usuario11','usuario11@gmail.com', 'estandar', '1978-06-22', crypt('usuario11', gen_salt('bf', 10))),
       ('Usuario12', 'Usuario12', 'Venus',   'Usuario12','usuario12@gmail.com', 'estandar', '1978-06-22', crypt('usuario12', gen_salt('bf', 10)));


INSERT INTO comunidades (denom, descripcion, propietario)
 VALUES 
 ('Escribir es para todos', 'Estaís todos invitados formar parte de la comunidad para escritores animaté y comparte tus ideas a con todos nosotros', 1),
 ('Viajes', 'Si te gusta viajar y comentar tus grandes aventuras esta es tu comunidad', 1),
 ('Videojuegos', 'Los videojuegos estan a la orden del día disfruta con más personas de este hobbit', 1),
 ('Ciencialistas', '¿Buscas una comunidad de aficionados a la ciencia? Entra aquí y comenta tus conocimientos', 1);

INSERT INTO blogs (titulo, descripcion, cuerpo, comunidad_id, usuario_id)
VALUES 
        ('Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
                'Lo mejor que me he leído hasta ahora de Shakespeare: 
                conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
                La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
                Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
                A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
                Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1),

        ('1Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
                'Lo mejor que me he leído hasta ahora de Shakespeare: 
                conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
                La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
                Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
                A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
                Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1),

        ('2Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
                'Lo mejor que me he leído hasta ahora de Shakespeare: 
                conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
                La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
                Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
                A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
                Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1),

        ('3Una obra de arte, Whiliam Shakespeare...', 'Opinion de la obra de Whiliam Shakespeare',  
                'Lo mejor que me he leído hasta ahora de Shakespeare: 
                conciso, sorprendente y para nada denso como muchas otras obras del escritor. 
                La historia tiene su miga: un duque de Milán desterrado de sus posesiones por su propio hermano condenado a vagar sin rumbo por el mar. 
                Pero haciendo servir sus dotes aprendidas en la corte como mago, logra dominar los elementos de la isla a la que llega y se convierte en una especie de Dios. 
                A diferencia de muchos otros personajes del autor, este logra perdonar a sus adversarios en su venganza. 
                Un cuento fantástico con espíritus de la naturaleza muy entretenido.', 1, 1);



INSERT INTO notas (nota, usuario_id, blog_id)
VALUES (5, 1, 1);         


INSERT INTO favblogs (usuario_id, blog_id)
VALUES (1, 1);    

INSERT INTO favcomunidades (usuario_id, comunidad_id, created_at)
VALUES  (1, 1, '2020-01-29 18:52:16'),
        (3, 1, '2020-03-29 18:52:16'),
        (4, 1, '2020-04-29 18:52:16'),
        (6, 1, '2020-06-29 18:52:16'),
        (7, 1, '2020-07-29 18:52:16'),
        (8, 1, '2020-07-29 18:52:16'),
        (9, 1, '2020-07-29 18:52:16'),
        (5, 1, '2020-07-29 18:52:16'),
        (2, 1, '2020-07-29 18:52:16');

        
INSERT INTO estados (estado)       
VALUES ('Conectado'),
       ('Ausente'),
       ('Ocupado'),
       ('Desconectado');


INSERT INTO integrantes (usuario_id, comunidad_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4);         



