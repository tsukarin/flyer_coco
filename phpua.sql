create table phpua(
  uid serial primary key,
  uname text not null,
  email text not null,
  password text not null) without oids;
