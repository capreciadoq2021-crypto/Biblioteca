-- BibTum: esquema y datos de ejemplo.
-- Uso (desde la carpeta del proyecto):
--   createdb -U postgres -E UTF8 bittum
--   psql -U postgres -d bittum -f database/bittum.sql

SET client_encoding = 'UTF8';

BEGIN;

DROP TABLE IF EXISTS public.book;
DROP TABLE IF EXISTS public.author;
DROP TABLE IF EXISTS public.category;

CREATE TABLE public.category (
    id    SERIAL PRIMARY KEY,
    name  VARCHAR(60) NOT NULL UNIQUE,
    state BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE public.author (
    id         SERIAL PRIMARY KEY,
    first_name VARCHAR(80) NOT NULL,
    last_name  VARCHAR(80) NOT NULL,
    born_date  DATE,
    pic_url    TEXT
);

CREATE TABLE public.book (
    id          SERIAL PRIMARY KEY,
    name_book   VARCHAR(200) NOT NULL,
    author_id   INTEGER NOT NULL REFERENCES public.author (id) ON DELETE RESTRICT,
    category_id INTEGER NOT NULL REFERENCES public.category (id) ON DELETE RESTRICT,
    description TEXT,
    date_lan    DATE,
    editorial   VARCHAR(120),
    rese        TEXT,
    img_book    TEXT
);

CREATE INDEX book_author_idx ON public.book (author_id);
CREATE INDEX book_category_idx ON public.book (category_id);

INSERT INTO public.category (name, state) VALUES
    ('ficción', TRUE),
    ('comedia', TRUE),
    ('ciencia', TRUE),
    ('historia', TRUE),
    ('poesía', FALSE);

INSERT INTO public.author (first_name, last_name, born_date, pic_url) VALUES
    ('Gabriel', 'García Márquez', '1927-03-06', NULL),
    ('Isabel', 'Allende', '1942-08-02', NULL),
    ('Carl', 'Sagan', '1934-11-09', NULL),
    ('Yuval Noah', 'Harari', '1976-02-24', NULL),
    ('Eduardo', 'Mendoza', '1943-01-11', NULL);

INSERT INTO public.book
    (name_book, author_id, category_id, description, date_lan, editorial, rese, img_book)
VALUES
    ('Cien años de soledad', 1, 1,
     'La historia de la familia Buendía a lo largo de siete generaciones en Macondo.',
     '1967-05-30', 'Sudamericana',
     'Obra cumbre del realismo mágico.', NULL),
    ('El amor en los tiempos del cólera', 1, 1,
     'Un amor que espera más de cincuenta años para cumplirse.',
     '1985-12-05', 'Oveja Negra',
     'Una novela sobre la constancia y el paso del tiempo.', NULL),
    ('La casa de los espíritus', 2, 1,
     'La saga de la familia Trueba a través de cuatro generaciones.',
     '1982-01-01', 'Plaza & Janés',
     'Debut de la autora y clásico de la literatura latinoamericana.', NULL),
    ('Cosmos', 3, 3,
     'Un recorrido por el universo y el lugar de la humanidad en él.',
     '1980-10-12', 'Random House',
     'Divulgación científica clara y apasionada.', NULL),
    ('Sapiens: de animales a dioses', 4, 4,
     'Breve historia de la humanidad desde la Edad de Piedra hasta hoy.',
     '2011-01-01', 'Debate',
     'Una mirada amplia y provocadora a nuestra especie.', NULL),
    ('Sin noticias de Gurb', 5, 2,
     'Un extraterrestre busca a su compañero perdido en la Barcelona preolímpica.',
     '1991-01-01', 'Seix Barral',
     'Humor absurdo y sátira de la vida urbana.', NULL);

COMMIT;
