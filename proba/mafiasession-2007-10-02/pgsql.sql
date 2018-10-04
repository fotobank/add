-- PGSQL
CREATE TABLE _session
(
  id_session serial NOT NULL,
  remote_addr integer NOT NULL,
  request_uri character varying(128) NOT NULL,
  keytime bigint NOT NULL,
  keepalive integer
) 
WITH OIDS;
CREATE TABLE "login"
(
  id_login serial NOT NULL,
  "login" character varying(20) NOT NULL,
  senhamd5 character varying(32) NOT NULL,
  senhasha1 character varying(40) NOT NULL
) 
WITH OIDS;