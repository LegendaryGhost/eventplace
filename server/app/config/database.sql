
CREATE TABLE events
(
  id      INT          NOT NULL AUTO_INCREMENT,
  name    VARCHAR(255) NOT NULL,
  date    DATETIME     NOT NULL,
  place   INT          NOT NULL,
  creator INT          NOT NULL,
  PRIMARY KEY (id)
);

ALTER TABLE events
  ADD CONSTRAINT UQ_id UNIQUE (id);

CREATE TABLE tickets
(
  id    INT                                            NOT NULL AUTO_INCREMENT,
  type  INT                                            NOT NULL,
  state ENUM('avalaible', 'bought', 'used', 'expired') NOT NULL,
  owner INT                                            NULL    ,
  PRIMARY KEY (id)
);

ALTER TABLE tickets
  ADD CONSTRAINT UQ_id UNIQUE (id);

CREATE TABLE ticket_types
(
  id    INT         NOT NULL AUTO_INCREMENT,
  name  VARCHAR(50) NOT NULL,
  price FLOAT       NOT NULL,
  event INT         NOT NULL,
  PRIMARY KEY (id)
);

ALTER TABLE ticket_types
  ADD CONSTRAINT UQ_id UNIQUE (id);

CREATE TABLE users
(
  id       INT                      NOT NULL AUTO_INCREMENT,
  name     VARCHAR(50)              NOT NULL,
  email    VARCHAR(255)             NOT NULL,
  password VARCHAR(50)              NOT NULL,
  type     ENUM('buyer', 'creator') NOT NULL,
  PRIMARY KEY (id)
);

ALTER TABLE users
  ADD CONSTRAINT UQ_id UNIQUE (id);

ALTER TABLE events
  ADD CONSTRAINT FK_users_TO_events
    FOREIGN KEY (creator)
    REFERENCES users (id);

ALTER TABLE ticket_types
  ADD CONSTRAINT FK_events_TO_ticket_types
    FOREIGN KEY (event)
    REFERENCES events (id);

ALTER TABLE tickets
  ADD CONSTRAINT FK_ticket_types_TO_tickets
    FOREIGN KEY (type)
    REFERENCES ticket_types (id);

ALTER TABLE tickets
  ADD CONSTRAINT FK_users_TO_tickets
    FOREIGN KEY (owner)
    REFERENCES users (id);
