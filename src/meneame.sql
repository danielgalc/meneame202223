CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id bigserial PRIMARY KEY,
    usuario varchar (255) NOT NULL UNIQUE,
    password varchar (255) NOT NULL
);

DROP TABLE IF EXISTS noticias CASCADE;

CREATE TABLE noticias (
    id bigserial primary key,
    titular varchar(255) not null,
    noticia_usuario BIGSERIAL NOT NULL REFERENCES usuarios (id),
    likes varchar (255)
);

-- Carga inicial de datos de prueba:

INSERT INTO usuarios (usuario, password)
VALUES ('admin', crypt('admin', gen_salt('bf', 10))),
       ('pepe', crypt('pepe', gen_salt('bf', 10))),
       ('dani', crypt('dani', gen_salt('bf', 10)));

INSERT INTO noticias (titular, noticia_usuario, likes)
VALUES ('Enrique aprueba en DAW', 1, 0),
       ('España pierde contra Japon', 2, 0);