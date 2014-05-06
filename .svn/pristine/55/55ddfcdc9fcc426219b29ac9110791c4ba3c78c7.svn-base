-- Creating rgentity table
CREATE TABLE rgentity
(
  id serial NOT NULL,
  dbview character varying(255) NOT NULL,
  name character varying(255) NOT NULL,
  CONSTRAINT rgentity_pkey PRIMARY KEY (id),
  CONSTRAINT rgentity_name_key UNIQUE (name)
)
WITH (
  OIDS=FALSE
);

-- END rgentity

-- Creating rgattr table

CREATE TABLE rgattr
(
  id serial NOT NULL,
  entity_id integer NOT NULL,
  dbname character varying(255) NOT NULL,
  filtertype integer DEFAULT 0,
  alias character varying(255),
  enabled boolean DEFAULT false,
  CONSTRAINT rgattr_pkey PRIMARY KEY (id),
  CONSTRAINT fk_rgattr FOREIGN KEY (entity_id)
      REFERENCES rgentity (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);


CREATE INDEX idx_rgattr_ent_id
  ON rgattr
  USING btree
  (entity_id);

-- END rgattr