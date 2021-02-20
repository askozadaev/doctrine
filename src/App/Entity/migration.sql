drop table account, post;
CREATE SEQUENCE acc_id_seq;
CREATE TABLE account (
                         id        integer NOT NULL PRIMARY KEY DEFAULT nextval('acc_id_seq'),
                         fullName       varchar(40) NOT NULL,
                         postId         integer NOT NULL
);
ALTER SEQUENCE acc_id_seq OWNED BY account.id;

CREATE SEQUENCE pst_id_seq;
CREATE TABLE post (
                      id        integer NOT NULL PRIMARY KEY DEFAULT nextval('pst_id_seq'),
                      name       varchar(40) NOT NULL
);
ALTER SEQUENCE pst_id_seq OWNED BY post.id;
--*-
INSERT INTO "post" (name) VALUES
('admin'),
('user');

--*-
INSERT INTO "account" (fullName, postId) VALUES
('Test User 1', 1),
('Test User 2', 2),
('Test User 3', 2);

--*-
SELECT	acc.id as account_id,
          acc.fullname as account_fullname,
          acc.postid as account_post_id,
          pst.name as post_name
FROM public.account acc
         INNER JOIN public.post pst
                    ON acc.postid = pst.id
WHERE acc.id = 1;