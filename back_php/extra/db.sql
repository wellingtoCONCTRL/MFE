-- Database: TCC

-- DROP DATABASE "TCC";

CREATE DATABASE "TCC"
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Portuguese_Brazil.1252'
    LC_CTYPE = 'Portuguese_Brazil.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;

-- Table: public.condominiums

-- DROP TABLE public.condominiums;

CREATE TABLE IF NOT EXISTS public.condominiums
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 999999 CACHE 1 ),
	cnpj_cpf character(14) COLLATE pg_catalog."default" NOT NULL,
    name character(100) COLLATE pg_catalog."default" NOT NULL,
	logradouro character(100) COLLATE pg_catalog."default" NOT NULL,
	bairro character(100) COLLATE pg_catalog."default" NOT NULL,
	cep character(10) COLLATE pg_catalog."default" NOT NULL,
	cidade character(50) COLLATE pg_catalog."default" NOT NULL,
	uf character(2) COLLATE pg_catalog."default" NOT NULL,
	email character(100) COLLATE pg_catalog."default" ,
    CONSTRAINT condominiums_pkey PRIMARY KEY (id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.condominiums
    OWNER to postgres;


-- Table: public.users

-- DROP TABLE public.users;

CREATE TABLE IF NOT EXISTS public.users
(
    id integer NOT NULL GENERATED ALWAYS AS IDENTITY ( INCREMENT 1 START 1 MINVALUE 1 MAXVALUE 999999 CACHE 1 ),
    name character(100) COLLATE pg_catalog."default" NOT NULL,
    password character(100) COLLATE pg_catalog."default" NOT NULL,
    email character(100) COLLATE pg_catalog."default" NOT NULL,
    start_date date NOT NULL,
    end_date date,
    is_admin boolean NOT NULL DEFAULT false,
    CONSTRAINT users_pkey PRIMARY KEY (id),
    CONSTRAINT users_email_key UNIQUE (email)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.users
    OWNER to postgres;	

-- senha "a"
INSERT INTO public.users(name, password, email, start_date, end_date, is_admin)
VALUES ('Administrador', '$2y$10$/vC1UKrEJQUZLN2iM3U9re/4DQP74sXCOVXlYXe/j9zuv1/MHD4o.', 'admin@conctrl.com.br', '2000-10-16', null, true);

INSERT INTO public.users(name, password, email, start_date, end_date, is_admin)
VALUES ('Operador', '$2y$10$/vC1UKrEJQUZLN2iM3U9re/4DQP74sXCOVXlYXe/j9zuv1/MHD4o.', 'oper@conctrl.com.br', '2000-10-20', null, false);
