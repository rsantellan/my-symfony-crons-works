CREATE TABLE actividades (id INT AUTO_INCREMENT, nombre VARCHAR(64) NOT NULL, costo FLOAT(6, 2) NOT NULL, horario ENUM('mañana', 'tarde', 'mañana y tarde'), md_news_letter_group_id INT, INDEX md_news_letter_group_id_idx (md_news_letter_group_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE billetera (id INT, credito BIGINT, deuda BIGINT, impuesto BIGINT, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE costos (id INT AUTO_INCREMENT, matricula FLOAT(6, 2) NOT NULL, matutino FLOAT(6, 2) NOT NULL, vespertino FLOAT(6, 2) NOT NULL, doble_horario FLOAT(6, 2) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE descuentos (id INT AUTO_INCREMENT, cantidad_de_hermanos BIGINT UNIQUE NOT NULL, porcentaje BIGINT NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE emails (id INT, type VARCHAR(32) NOT NULL, from_name VARCHAR(64) NOT NULL, from_mail VARCHAR(64) NOT NULL, UNIQUE INDEX type_index_idx (type), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE exoneracion (id INT AUTO_INCREMENT, usuario_id INT NOT NULL, mes ENUM('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'), fecha DATETIME NOT NULL, INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE hermanos (usuario_from INT, usuario_to INT, PRIMARY KEY(usuario_from, usuario_to)) ENGINE = INNODB;
CREATE TABLE md_blocked_users (md_user_id INT, reason VARCHAR(128), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(md_user_id)) ENGINE = INNODB;
CREATE TABLE md_content (id INT AUTO_INCREMENT, md_user_id INT NOT NULL, object_class VARCHAR(128) NOT NULL, object_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_user_id_idx (md_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_content_relation (md_content_id_first INT, md_content_id_second INT, object_class_name VARCHAR(128) NOT NULL, profile_name VARCHAR(128), PRIMARY KEY(md_content_id_first, md_content_id_second)) ENGINE = INNODB;
CREATE TABLE md_galeria_translation (id INT, titulo VARCHAR(128), descripcion TEXT NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) ENGINE = INNODB;
CREATE TABLE md_galeria (id INT AUTO_INCREMENT, curso_verde TINYINT(1) DEFAULT '0', curso_rojo TINYINT(1) DEFAULT '0', curso_amarillo TINYINT(1) DEFAULT '0', position BIGINT, UNIQUE INDEX md_galeria_position_sortable_idx (position), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_i18_n_manage_classes (id INT AUTO_INCREMENT, class_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media (id INT AUTO_INCREMENT, object_class_name VARCHAR(128) NOT NULL, object_id INT NOT NULL, UNIQUE INDEX md_media_index_idx (object_class_name, object_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_album (id INT AUTO_INCREMENT, md_media_id INT, title VARCHAR(64) NOT NULL, description VARCHAR(255), type ENUM('Image', 'Video', 'File', 'Mixed') DEFAULT 'Mixed', deleteallowed bool NOT NULL, md_media_content_id INT, counter_content BIGINT DEFAULT 0, UNIQUE INDEX md_media_album_title_index_idx (md_media_id, title), INDEX md_media_content_id_idx (md_media_content_id), INDEX md_media_id_idx (md_media_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_album_content (md_media_album_id INT, md_media_content_id INT, object_class_name VARCHAR(128) NOT NULL, priority BIGINT NOT NULL, INDEX md_media_album_content_index_idx (priority ASC), PRIMARY KEY(md_media_album_id, md_media_content_id)) ENGINE = INNODB;
CREATE TABLE md_media_content (id INT AUTO_INCREMENT, object_class_name VARCHAR(128) NOT NULL, object_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX md_media_content_index_idx (object_class_name, object_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_file (id INT AUTO_INCREMENT, name VARCHAR(64) NOT NULL, filename VARCHAR(64) NOT NULL, filetype VARCHAR(64) NOT NULL, description VARCHAR(255), path VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_image (id INT AUTO_INCREMENT, name VARCHAR(64) NOT NULL, filename VARCHAR(64) NOT NULL, description VARCHAR(255), path VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_issuu_video (id INT AUTO_INCREMENT, documentid TEXT NOT NULL, embed_code text NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_video (id INT AUTO_INCREMENT, name VARCHAR(64) NOT NULL, filename VARCHAR(64) NOT NULL, duration VARCHAR(64) NOT NULL, type VARCHAR(64) NOT NULL, description VARCHAR(255), path VARCHAR(255), avatar VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_vimeo_video (id INT AUTO_INCREMENT, vimeo_url VARCHAR(64) NOT NULL, title VARCHAR(255) NOT NULL, src VARCHAR(255) NOT NULL, duration VARCHAR(64) NOT NULL, description TEXT, avatar VARCHAR(255), avatar_width TINYINT, avatar_height TINYINT, author_name VARCHAR(255), author_url VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_media_youtube_video (id INT AUTO_INCREMENT, name VARCHAR(64) NOT NULL, src VARCHAR(255) NOT NULL, code VARCHAR(64) NOT NULL, duration VARCHAR(64) NOT NULL, description VARCHAR(255), path VARCHAR(255), avatar VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_news_letter_group (id INT AUTO_INCREMENT, name TEXT NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_news_letter_group_sended (md_newsletter_group_id INT, md_newsletter_contend_sended_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(md_newsletter_group_id, md_newsletter_contend_sended_id)) ENGINE = INNODB;
CREATE TABLE md_news_letter_group_user (md_newsletter_group_id INT, md_newsletter_user_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(md_newsletter_group_id, md_newsletter_user_id)) ENGINE = INNODB;
CREATE TABLE md_news_letter_user (id INT AUTO_INCREMENT, md_user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_user_id_idx (md_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_newsletter_content (id INT AUTO_INCREMENT, subject TEXT NOT NULL, body LONGBLOB NOT NULL, send_counter INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_newsletter_content_sended (id INT AUTO_INCREMENT, subject TEXT NOT NULL, body LONGBLOB NOT NULL, send_counter INT NOT NULL, sending_date DATETIME, sended TINYINT(1) DEFAULT '0', for_status SMALLINT DEFAULT 0, md_newsletter_content_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_newsletter_content_id_idx (md_newsletter_content_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_newsletter_send (id INT AUTO_INCREMENT, md_news_letter_user_id INT NOT NULL, md_newsletter_content_sended_id INT NOT NULL, sending_date DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_news_letter_user_id_idx (md_news_letter_user_id), INDEX md_newsletter_content_sended_id_idx (md_newsletter_content_sended_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_passport (id INT AUTO_INCREMENT, md_user_id INT NOT NULL, username VARCHAR(128) NOT NULL, password VARCHAR(128) NOT NULL, account_active TINYINT DEFAULT '0' NOT NULL, account_blocked TINYINT DEFAULT '0' NOT NULL, last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_user_id_idx (md_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_passport_remember_key (id INT AUTO_INCREMENT, md_passport_id INT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX md_passport_id_idx (md_passport_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE md_user (id INT AUTO_INCREMENT, email VARCHAR(128) NOT NULL UNIQUE, super_admin TINYINT DEFAULT '0' NOT NULL, culture VARCHAR(2), deleted_at DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_user_profile (id INT AUTO_INCREMENT, name VARCHAR(128), last_name VARCHAR(128), city VARCHAR(128), country_code VARCHAR(2) DEFAULT 'UY', PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE md_user_search (id BIGINT AUTO_INCREMENT, md_user_id INT NOT NULL, email VARCHAR(128), username VARCHAR(128), name VARCHAR(128), last_name VARCHAR(128), country_code VARCHAR(2), avatar_src TEXT, active TINYINT(1) DEFAULT '0', blocked TINYINT(1) DEFAULT '0', admin TINYINT(1) DEFAULT '0', show_email TINYINT(1) DEFAULT '0', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX username_index_idx (username), INDEX email_index_idx (email), INDEX last_name_index_idx (last_name), INDEX name_index_idx (name), INDEX md_user_id_idx (md_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE pagos (id INT AUTO_INCREMENT, usuario_id INT NOT NULL, price BIGINT NOT NULL, mes ENUM('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'), fecha DATETIME NOT NULL, out_of_date TINYINT(1) DEFAULT '0' NOT NULL, INDEX usuario_id_idx (usuario_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE progenitor (id INT AUTO_INCREMENT, nombre VARCHAR(64), direccion VARCHAR(128), telefono VARCHAR(128), celular VARCHAR(64), mail VARCHAR(64), clave VARCHAR(64), md_user_id INT, UNIQUE INDEX mail_index_idx (mail), INDEX md_user_id_idx (md_user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario (id INT AUTO_INCREMENT, nombre VARCHAR(64) NOT NULL, apellido VARCHAR(64) NOT NULL, fecha_nacimiento DATETIME, anio_ingreso BIGINT, direccion VARCHAR(128), telefono VARCHAR(128), sociedad VARCHAR(64), referencia_bancaria VARCHAR(64) NOT NULL, emergencia_medica VARCHAR(64), nombre_padres VARCHAR(64), celular_padres VARCHAR(64), mail_padres VARCHAR(64), horario ENUM('matutino', 'vespertino', 'doble_horario'), futuro_colegio VARCHAR(64), descuento BIGINT, clase ENUM('verde', 'amarillo', 'rojo'), egresado TINYINT(1) DEFAULT '0', billetera_id INT, md_user_id INT, INDEX billetera_id_idx (billetera_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE usuario_actividades (usuario_id INT, actividad_id INT, PRIMARY KEY(usuario_id, actividad_id)) ENGINE = INNODB;
CREATE TABLE usuario_progenitor (usuario_id INT, progenitor_id INT, PRIMARY KEY(usuario_id, progenitor_id)) ENGINE = INNODB;
ALTER TABLE actividades ADD CONSTRAINT actividades_md_news_letter_group_id_md_news_letter_group_id FOREIGN KEY (md_news_letter_group_id) REFERENCES md_news_letter_group(id);
ALTER TABLE exoneracion ADD CONSTRAINT exoneracion_usuario_id_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE hermanos ADD CONSTRAINT hermanos_usuario_to_usuario_id FOREIGN KEY (usuario_to) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE hermanos ADD CONSTRAINT hermanos_usuario_from_usuario_id FOREIGN KEY (usuario_from) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE md_content ADD CONSTRAINT md_content_md_user_id_md_user_id FOREIGN KEY (md_user_id) REFERENCES md_user(id) ON DELETE CASCADE;
ALTER TABLE md_content_relation ADD CONSTRAINT md_content_relation_md_content_id_second_md_content_id FOREIGN KEY (md_content_id_second) REFERENCES md_content(id);
ALTER TABLE md_content_relation ADD CONSTRAINT md_content_relation_md_content_id_first_md_content_id FOREIGN KEY (md_content_id_first) REFERENCES md_content(id);
ALTER TABLE md_galeria_translation ADD CONSTRAINT md_galeria_translation_id_md_galeria_id FOREIGN KEY (id) REFERENCES md_galeria(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE md_media_album ADD CONSTRAINT md_media_album_md_media_id_md_media_id FOREIGN KEY (md_media_id) REFERENCES md_media(id);
ALTER TABLE md_media_album ADD CONSTRAINT md_media_album_md_media_content_id_md_media_content_id FOREIGN KEY (md_media_content_id) REFERENCES md_media_content(id);
ALTER TABLE md_media_album_content ADD CONSTRAINT md_media_album_content_md_media_content_id_md_media_content_id FOREIGN KEY (md_media_content_id) REFERENCES md_media_content(id);
ALTER TABLE md_media_album_content ADD CONSTRAINT md_media_album_content_md_media_album_id_md_media_album_id FOREIGN KEY (md_media_album_id) REFERENCES md_media_album(id);
ALTER TABLE md_news_letter_group_sended ADD CONSTRAINT mmmi_1 FOREIGN KEY (md_newsletter_contend_sended_id) REFERENCES md_newsletter_content_sended(id) ON DELETE CASCADE;
ALTER TABLE md_news_letter_group_sended ADD CONSTRAINT mmmi FOREIGN KEY (md_newsletter_group_id) REFERENCES md_news_letter_group(id) ON DELETE CASCADE;
ALTER TABLE md_news_letter_group_user ADD CONSTRAINT mmmi_3 FOREIGN KEY (md_newsletter_user_id) REFERENCES md_news_letter_user(id) ON DELETE CASCADE;
ALTER TABLE md_news_letter_group_user ADD CONSTRAINT mmmi_2 FOREIGN KEY (md_newsletter_group_id) REFERENCES md_news_letter_group(id) ON DELETE CASCADE;
ALTER TABLE md_news_letter_user ADD CONSTRAINT md_news_letter_user_md_user_id_md_user_id FOREIGN KEY (md_user_id) REFERENCES md_user(id) ON DELETE CASCADE;
ALTER TABLE md_newsletter_content_sended ADD CONSTRAINT mmmi_4 FOREIGN KEY (md_newsletter_content_id) REFERENCES md_newsletter_content(id) ON DELETE CASCADE;
ALTER TABLE md_newsletter_send ADD CONSTRAINT mmmi_5 FOREIGN KEY (md_newsletter_content_sended_id) REFERENCES md_newsletter_content_sended(id) ON DELETE CASCADE;
ALTER TABLE md_newsletter_send ADD CONSTRAINT md_newsletter_send_md_news_letter_user_id_md_news_letter_user_id FOREIGN KEY (md_news_letter_user_id) REFERENCES md_news_letter_user(id) ON DELETE CASCADE;
ALTER TABLE md_passport ADD CONSTRAINT md_passport_md_user_id_md_user_id FOREIGN KEY (md_user_id) REFERENCES md_user(id);
ALTER TABLE md_passport_remember_key ADD CONSTRAINT md_passport_remember_key_md_passport_id_md_passport_id FOREIGN KEY (md_passport_id) REFERENCES md_passport(id) ON DELETE CASCADE;
ALTER TABLE md_user_search ADD CONSTRAINT md_user_search_md_user_id_md_user_id FOREIGN KEY (md_user_id) REFERENCES md_user(id) ON DELETE CASCADE;
ALTER TABLE pagos ADD CONSTRAINT pagos_usuario_id_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE progenitor ADD CONSTRAINT progenitor_md_user_id_md_user_id FOREIGN KEY (md_user_id) REFERENCES md_user(id) ON DELETE CASCADE;
ALTER TABLE usuario ADD CONSTRAINT usuario_billetera_id_billetera_id FOREIGN KEY (billetera_id) REFERENCES billetera(id);
ALTER TABLE usuario_actividades ADD CONSTRAINT usuario_actividades_usuario_id_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE usuario_actividades ADD CONSTRAINT usuario_actividades_actividad_id_actividades_id FOREIGN KEY (actividad_id) REFERENCES actividades(id) ON DELETE CASCADE;
ALTER TABLE usuario_progenitor ADD CONSTRAINT usuario_progenitor_usuario_id_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE;
ALTER TABLE usuario_progenitor ADD CONSTRAINT usuario_progenitor_progenitor_id_progenitor_id FOREIGN KEY (progenitor_id) REFERENCES progenitor(id) ON DELETE CASCADE;