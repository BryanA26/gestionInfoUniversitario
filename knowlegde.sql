-- MySQL Script generated by MySQL Workbench
-- Fri Oct 11 08:14:40 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema knowledge_map_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `universidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `universidad` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `ciudad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `facultad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `facultad` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `fecha_fun` DATE NOT NULL,
  `universidad` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_unidad_sede_idx` (`universidad`),
  CONSTRAINT `fk_unidad_sede`
    FOREIGN KEY (`universidad`)
    REFERENCES `universidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `programa` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `nivel` VARCHAR(45) NOT NULL,
  `fecha_creacion` VARCHAR(45) NOT NULL,
  `fecha_cierre` VARCHAR(45) NULL,
  `numero_cohortes` VARCHAR(45) NOT NULL,
  `cant_graduados` VARCHAR(45) NOT NULL,
  `fecha_actualizacion` VARCHAR(45) NOT NULL,
  `ciudad` VARCHAR(45) NOT NULL,
  `facultad` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_programa_facultad_idx` (`facultad`),
  CONSTRAINT `fk_programa_facultad`
    FOREIGN KEY (`facultad`)
    REFERENCES `facultad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `linea_investigacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `linea_investigacion` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docente` (
  `cedula` INT(11) NOT NULL,
  `nombres` VARCHAR(60) NOT NULL,
  `apellidos` VARCHAR(60) NOT NULL,
  `genero` VARCHAR(12) NOT NULL,
  `cargo` VARCHAR(30) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `correo` VARCHAR(70) NOT NULL,
  `telefono` VARCHAR(20) NOT NULL,
  `url_cvlac` VARCHAR(128) NOT NULL,
  `fecha_actualizacion` DATE NOT NULL,
  `escalafon` VARCHAR(45) NOT NULL,
  `perfil` LONGTEXT NOT NULL,
  `cat_minciencia` VARCHAR(45) NULL,
  `conv_minciencia` VARCHAR(45) NOT NULL,
  `nacionalidaad` VARCHAR(45) NOT NULL,
  `linea_investigacion_principal` INT(10) NULL,
  PRIMARY KEY (`cedula`),
  INDEX `fk_docente_linea_investigacion_idx` (`linea_investigacion_principal`),
  CONSTRAINT `fk_docente_linea_investigacion`
    FOREIGN KEY (`linea_investigacion_principal`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estudios_realizados`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estudios_realizados` (
  `id` INT(10) NOT NULL,
  `titulo` VARCHAR(45) NOT NULL,
  `universidad` VARCHAR(50) NOT NULL,
  `fecha` DATE NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `ciudad` VARCHAR(45) NOT NULL,
  `docente` INT(11) NOT NULL,
  `ins_acreditada` TINYINT NOT NULL,
  `metodologia` VARCHAR(45) NOT NULL,
  `perfil_egresado` LONGTEXT NOT NULL,
  `pais` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_estudio_docente_idx` (`docente`),
  CONSTRAINT `fk_estudio_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aliado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aliado` (
  `nit` INT(15) NOT NULL,
  `razon_social` VARCHAR(60) NOT NULL,
  `nombre_contacto` VARCHAR(60) NOT NULL,
  `correo` VARCHAR(70) NOT NULL,
  `telefono` VARCHAR(45) NOT NULL,
  `ciudad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`nit`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id` INT(10) NOT NULL,
  `titulo` VARCHAR(70) NOT NULL,
  `resumen` VARCHAR(256) NOT NULL,
  `presupuesto` DOUBLE NOT NULL,
  `tipo_financiacion` VARCHAR(45) NOT NULL,
  `tipo_fondos` VARCHAR(45) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tipo_producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tipo_producto` (
  `id` INT NOT NULL,
  `categoria` VARCHAR(45) NOT NULL,
  `clase` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `tipologia` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `producto` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `categoria` VARCHAR(45) NOT NULL,
  `fecha_entrega` DATE NOT NULL,
  `proyecto` INT(10) NULL,
  `tipo_producto` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_producto_proyecto_idx` (`proyecto`),
  INDEX `fk_producto_tipo_producto_idx` (`tipo_producto`),
  CONSTRAINT `fk_producto_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_tipo_producto`
    FOREIGN KEY (`tipo_producto`)
    REFERENCES `tipo_producto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `termino_clave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `termino_clave` (
  `termino` VARCHAR(30) NOT NULL,
  `termino_ingles` VARCHAR(30) NULL,
  PRIMARY KEY (`termino`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `area_aplicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `area_aplicacion` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `objetivo_desarrollo_sostenible`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `objetivo_desarrollo_sostenible` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `categoria` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `area_conocimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `area_conocimiento` (
  `id` INT(10) NOT NULL,
  `gran_area` VARCHAR(60) NOT NULL,
  `area` VARCHAR(60) NOT NULL,
  `disciplina` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_investigacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_investigacion` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `url_gruplac` VARCHAR(128) NULL,
  `categoria` VARCHAR(10) NULL,
  `convocatoria` VARCHAR(10) NULL,
  `fecha_fundacion` DATE NOT NULL,
  `universidsad` INT(10) NULL,
  `interno` TINYINT NOT NULL,
  `ambito` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_grupo_investigacion_sede_idx` (`universidsad`),
  CONSTRAINT `fk_grupo_investigacion_sede`
    FOREIGN KEY (`universidsad`)
    REFERENCES `universidad` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `semillero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semillero` (
  `id` INT(10) NOT NULL,
  `nombre` VARCHAR(60) NOT NULL,
  `fecha_fundacion` DATE NOT NULL,
  `grupo_investigacion` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_semillero_grupo_investigacion_idx` (`grupo_investigacion`),
  CONSTRAINT `fk_semillero_grupo_investigacion`
    FOREIGN KEY (`grupo_investigacion`)
    REFERENCES `grupo_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `semillero_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `semillero_linea` (
  `semillero` INT(10) NOT NULL,
  `linea_investigacion` INT(10) NOT NULL,
  PRIMARY KEY (`semillero`, `linea_investigacion`),
  INDEX `fk_semillero_linea_linea_idx` (`linea_investigacion`),
  INDEX `fk_semillero_linea_semillero_idx` (`semillero`),
  CONSTRAINT `fk_semillero_linea_semillero`
    FOREIGN KEY (`semillero`)
    REFERENCES `semillero` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_semillero_linea_linea`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `grupo_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `grupo_linea` (
  `grupo_investigacion` INT(10) NOT NULL,
  `linea_investigacion` INT(10) NOT NULL,
  PRIMARY KEY (`grupo_investigacion`, `linea_investigacion`),
  INDEX `fk_grupo_linea_linea_idx` (`linea_investigacion`),
  INDEX `fk_grupo_linea_grupo_idx` (`grupo_investigacion`),
  CONSTRAINT `fk_grupo_linea_grupo`
    FOREIGN KEY (`grupo_investigacion`)
    REFERENCES `grupo_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_linea_linea`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `docente_departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docente_departamento` (
  `docente` INT(11) NOT NULL,
  `departamento` INT(10) NOT NULL,
  `dedicacion` VARCHAR(15) NOT NULL,
  `modalidad` VARCHAR(45) NOT NULL,
  `fecha_ingreso` DATE NOT NULL,
  `fecha_salida` DATE NULL,
  PRIMARY KEY (`docente`, `departamento`),
  INDEX `fk_docente_departamento_departamento_idx` (`departamento`),
  INDEX `fk_docente_departamento_docente_idx` (`docente`),
  CONSTRAINT `fk_docente_departamento_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_docente_departamento_departamento`
    FOREIGN KEY (`departamento`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `participa_semillero`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `participa_semillero` (
  `docente` INT(11) NOT NULL,
  `semillero` INT(10) NOT NULL,
  `rol` VARCHAR(15) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  PRIMARY KEY (`docente`, `semillero`),
  INDEX `fk_participa_semillero_semillero_idx` (`semillero`),
  INDEX `fk_participa_semillero_docente_idx` (`docente`),
  CONSTRAINT `fk_participa_semillero_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_participa_semillero_semillero`
    FOREIGN KEY (`semillero`)
    REFERENCES `semillero` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `participa_grupo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `participa_grupo` (
  `docente_cedula` INT(11) NOT NULL,
  `grupo_investigacion_id` INT(10) NOT NULL,
  `rol` VARCHAR(15) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  PRIMARY KEY (`docente_cedula`, `grupo_investigacion_id`),
  INDEX `fk_participa_grupo_grupo_idx` (`grupo_investigacion_id`),
  INDEX `fk_participa_grupo_docente_idx` (`docente_cedula`),
  CONSTRAINT `fk_participa_grupo_docente`
    FOREIGN KEY (`docente_cedula`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_participa_grupo_grupo`
    FOREIGN KEY (`grupo_investigacion_id`)
    REFERENCES `grupo_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `alianza`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `alianza` (
  `aliado` INT(15) NOT NULL,
  `departamento` INT(10) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  `docente` INT(11) NULL,
  PRIMARY KEY (`aliado`, `departamento`),
  INDEX `fk_alianza_departamento_idx` (`departamento`),
  INDEX `fk_alianza_aliado_idx` (`aliado`),
  INDEX `fk_alianza_docente_idx` (`docente`),
  CONSTRAINT `fk_alianza_aliado`
    FOREIGN KEY (`aliado`)
    REFERENCES `aliado` (`nit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alianza_departamento`
    FOREIGN KEY (`departamento`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_alianza_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aliado_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aliado_proyecto` (
  `aliado` INT(15) NOT NULL,
  `proyecto` INT(10) NOT NULL,
  PRIMARY KEY (`aliado`, `proyecto`),
  INDEX `fk_aliado_proyecto_proyecto_idx` (`proyecto`),
  INDEX `fk_aliado_proyecto_aliado_idx` (`aliado`),
  CONSTRAINT `fk_aliado_proyecto_aliado`
    FOREIGN KEY (`aliado`)
    REFERENCES `aliado` (`nit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aliado_proyecto_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `desarrolla`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `desarrolla` (
  `docente` INT(11) NOT NULL,
  `proyecto` INT(10) NOT NULL,
  `rol` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(256) NOT NULL,
  PRIMARY KEY (`docente`, `proyecto`),
  INDEX `fk_desarrolla_proyecto_idx` (`proyecto`),
  INDEX `fk_desarrolla_docente_idx` (`docente`),
  CONSTRAINT `fk_desarrolla_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_desarrolla_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `palabras_clave`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `palabras_clave` (
  `proyecto` INT(10) NOT NULL,
  `termino_clave` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`proyecto`, `termino_clave`),
  INDEX `fk_palabras_clave_termino_clave_idx` (`termino_clave`),
  INDEX `fk_palabras_clave_proyecto_idx` (`proyecto`),
  CONSTRAINT `fk_palabras_clave_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_palabras_clave_termino_clave`
    FOREIGN KEY (`termino_clave`)
    REFERENCES `termino_clave` (`termino`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ac_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ac_proyecto` (
  `proyecto` INT(10) NOT NULL,
  `area_conocimiento` INT(10) NOT NULL,
  PRIMARY KEY (`proyecto`, `area_conocimiento`),
  INDEX `fk_ac_proyecto_area_conocimiento_idx` (`area_conocimiento`),
  INDEX `fk_ac_proyecto_proyecto_idx` (`proyecto`),
  CONSTRAINT `fk_ac_proyecto_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ac_proyecto_area_conocimiento`
    FOREIGN KEY (`area_conocimiento`)
    REFERENCES `area_conocimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proyecto_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyecto_linea` (
  `proyecto` INT(10) NOT NULL,
  `linea_investigacion` INT(10) NOT NULL,
  PRIMARY KEY (`proyecto`, `linea_investigacion`),
  INDEX `fk_proyecto_linea_linea_investigacion_idx` (`linea_investigacion`),
  INDEX `fk_proyecto_linea_proyecto_idx` (`proyecto`),
  CONSTRAINT `fk_proyecto_linea_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_linea_linea_investigacion`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ods_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ods_proyecto` (
  `proyecto` INT(10) NOT NULL,
  `ods` INT(10) NOT NULL,
  PRIMARY KEY (`proyecto`, `ods`),
  INDEX `fk_ods_proyecto_ods_idx` (`ods`),
  INDEX `fk_ods_proyecto_proyecto_idx` (`proyecto`),
  CONSTRAINT `fk_ods_proyecto_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ods_proyecto_ods`
    FOREIGN KEY (`ods`)
    REFERENCES `objetivo_desarrollo_sostenible` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aa_proyecto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aa_proyecto` (
  `proyecto` INT(10) NOT NULL,
  `area_aplicacion` INT(10) NOT NULL,
  PRIMARY KEY (`proyecto`, `area_aplicacion`),
  INDEX `fk_aa_proyecto_area_aplicacion_idx` (`area_aplicacion`),
  INDEX `fk_aa_proyecto_proyecto_idx` (`proyecto`),
  CONSTRAINT `fk_aa_proyecto_proyecto`
    FOREIGN KEY (`proyecto`)
    REFERENCES `proyecto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aa_proyecto_area_aplicacion`
    FOREIGN KEY (`area_aplicacion`)
    REFERENCES `area_aplicacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ac_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ac_linea` (
  `linea_investigacion` INT(10) NOT NULL,
  `area_conocimiento` INT(10) NOT NULL,
  PRIMARY KEY (`linea_investigacion`, `area_conocimiento`),
  INDEX `fk_ac_linea_area_conocimiento_idx` (`area_conocimiento`),
  INDEX `fk_ac_linea_linea_investigacion_idx` (`linea_investigacion`),
  CONSTRAINT `fk_ac_linea_linea_investigacion`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ac_linea_area_conocimie`
    FOREIGN KEY (`area_conocimiento`)
    REFERENCES `area_conocimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ods_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ods_linea` (
  `linea_investigacion` INT(10) NOT NULL,
  `ods` INT(10) NOT NULL,
  PRIMARY KEY (`linea_investigacion`, `ods`),
  INDEX `fk_ods_linea_ods_idx` (`ods`),
  INDEX `fk_ods_linea_linea_idx` (`linea_investigacion`),
  CONSTRAINT `fk_ods_linea_linea`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ods_linea_ods`
    FOREIGN KEY (`ods`)
    REFERENCES `objetivo_desarrollo_sostenible` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aa_linea`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aa_linea` (
  `area_aplicacion` INT(10) NOT NULL,
  `linea_investigacion` INT(10) NOT NULL,
  PRIMARY KEY (`area_aplicacion`, `linea_investigacion`),
  INDEX `fk_aa_linea_linea_investigacion_idx` (`linea_investigacion`),
  INDEX `fk_aa_linea_area_aplicacion_idx` (`area_aplicacion`),
  CONSTRAINT `fk_aa_linea_area_aplicacion`
    FOREIGN KEY (`area_aplicacion`)
    REFERENCES `area_aplicacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aa_linea_linea_investigacion`
    FOREIGN KEY (`linea_investigacion`)
    REFERENCES `linea_investigacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `docente_producto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docente_producto` (
  `docente` INT(11) NOT NULL,
  `producto` INT(10) NOT NULL,
  PRIMARY KEY (`docente`, `producto`),
  INDEX `fk_docente_producto_producto_idx` (`producto`),
  INDEX `fk_docente_producto_docente_idx` (`docente`),
  CONSTRAINT `fk_docente_producto_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_docente_producto_producto`
    FOREIGN KEY (`producto`)
    REFERENCES `producto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `estudio_ac`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `estudio_ac` (
  `estudio` INT(10) NOT NULL,
  `area_conocimiento` INT(10) NOT NULL,
  PRIMARY KEY (`estudio`, `area_conocimiento`),
  INDEX `fk_estudio_ac_area_conocimiento_idx` (`area_conocimiento`),
  INDEX `fk_estudio_ac_estudio_idx` (`estudio`),
  CONSTRAINT `fk_estudio_ac_estudio`
    FOREIGN KEY (`estudio`)
    REFERENCES `estudios_realizados` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudio_ac_area_conocimiento`
    FOREIGN KEY (`area_conocimiento`)
    REFERENCES `area_conocimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `apoyo_profesoral`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `apoyo_profesoral` (
  `estudios` INT(10) NOT NULL,
  `con_apoyo` TINYINT NOT NULL,
  `institucion` VARCHAR(45) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`estudios`),
  CONSTRAINT `fk_apoyo_profesoral_estudios1`
    FOREIGN KEY (`estudios`)
    REFERENCES `estudios_realizados` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `beca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `beca` (
  `estudios` INT(10) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `institucion` VARCHAR(80) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  PRIMARY KEY (`estudios`),
  CONSTRAINT `fk_beca_estudios1`
    FOREIGN KEY (`estudios`)
    REFERENCES `estudios_realizados` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `evaluacion_docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `evaluacion_docente` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `calificacion` FLOAT NOT NULL,
  `semestre` VARCHAR(45) NOT NULL,
  `docente` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_evaluacion_docente_docente_idx` (`docente`),
  CONSTRAINT `fk_evaluacion_docente_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reconocimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reconocimiento` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(45) NOT NULL,
  `fecha` DATE NOT NULL,
  `institucion` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `ambito` VARCHAR(45) NOT NULL,
  `docente` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_reconocimiento_docente_idx` (`docente`),
  CONSTRAINT `fk_reconocimiento_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `red`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red` (
  `idr` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `url` VARCHAR(45) NOT NULL,
  `pais` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idr`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `red_docente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red_docente` (
  `red` INT NOT NULL,
  `docente` INT(11) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` VARCHAR(45) NULL,
  `act_destacadas` LONGTEXT NOT NULL,
  PRIMARY KEY (`red`, `docente`),
  INDEX `fk_red_docente_docente_idx` (`docente`),
  INDEX `fk_red_docente_redes_idx` (`red`),
  CONSTRAINT `fk_red_docente_redes`
    FOREIGN KEY (`red`)
    REFERENCES `red` (`idr`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_red_docente_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `experiecia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `experiecia` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre_cargo` VARCHAR(45) NOT NULL,
  `institucion` VARCHAR(45) NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NULL,
  `docente` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_experiecia_docente_idx` (`docente`),
  CONSTRAINT `fk_experiecia_docente`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `programa_ac`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `programa_ac` (
  `programa` INT(10) NOT NULL,
  `area_conocimiento` INT(10) NOT NULL,
  PRIMARY KEY (`programa`, `area_conocimiento`),
  INDEX `fk_programa_ac_area_conocimiento_idx` (`area_conocimiento`),
  INDEX `fk_programa_ac_programa_idx` (`programa`),
  CONSTRAINT `fk_programa_ac_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_programa_ac_area_conocimiento`
    FOREIGN KEY (`area_conocimiento`)
    REFERENCES `area_conocimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `acreditacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `acreditacion` (
  `resolucion` INT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `calificacion` VARCHAR(45) NOT NULL,
  `fecha_inicio` VARCHAR(45) NOT NULL,
  `fecha_fin` VARCHAR(45) NOT NULL,
  `programa` INT(10) NOT NULL,
  PRIMARY KEY (`resolucion`),
  INDEX `fk_acreditacion_programa_idx` (`programa`),
  CONSTRAINT `fk_acreditacion_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `registro_calificado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `registro_calificado` (
  `codigo` INT NOT NULL,
  `cant_creditos` VARCHAR(45) NOT NULL,
  `hora_acom` VARCHAR(45) NOT NULL,
  `hora_ind` VARCHAR(45) NOT NULL,
  `metodologia` VARCHAR(45) NOT NULL,
  `fecha_inicio` DATE NOT NULL,
  `fecha_fin` DATE NOT NULL,
  `duracion_anios` VARCHAR(45) NOT NULL,
  `duracion_semestres` VARCHAR(45) NOT NULL,
  `tipo_titulacion` VARCHAR(45) NOT NULL,
  `programa` INT(10) NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_registro_calificado_programa_idx` (`programa`),
  CONSTRAINT `fk_registro_calificado_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `activ_academica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `activ_academica` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `num_creditos` INT NOT NULL,
  `tipo` VARCHAR(20) NOT NULL COMMENT 'obligatorio/electivo',
  `area_formacion` VARCHAR(45) NOT NULL,
  `h_acom` INT NOT NULL,
  `h_indep` INT NOT NULL,
  `idioma` VARCHAR(45) NOT NULL,
  `espejo` TINYINT NOT NULL,
  `entidad_espejo` VARCHAR(45) NOT NULL,
  `pais_espejo` VARCHAR(45) NOT NULL,
  `disenio` INT(10) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_activ_academicas_programa_idx` (`disenio`),
  CONSTRAINT `fk_activ_academicas_programa`
    FOREIGN KEY (`disenio`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `enfoque`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enfoque` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `enfoque_rc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enfoque_rc` (
  `enfoque` INT NOT NULL,
  `registro_calificado` INT NOT NULL,
  PRIMARY KEY (`enfoque`, `registro_calificado`),
  INDEX `fk_enfoque_rc_registro_calificado_idx` (`registro_calificado`),
  INDEX `fk_enfoque_rc_enfoque_idx` (`enfoque`),
  CONSTRAINT `fk_enfoque_rc_enfoque`
    FOREIGN KEY (`enfoque`)
    REFERENCES `enfoque` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_enfoque_rc_registro_calificado`
    FOREIGN KEY (`registro_calificado`)
    REFERENCES `registro_calificado` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aspecto_normativo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aspecto_normativo` (
  `id` INT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `fuente` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `an_programa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `an_programa` (
  `aspecto_normativo` INT NOT NULL,
  `programa` INT(10) NOT NULL,
  PRIMARY KEY (`aspecto_normativo`, `programa`),
  INDEX `fk_an_programa_programa_idx` (`programa`),
  INDEX `fk_an_programa_aspecto_normativo_idx` (`aspecto_normativo`),
  CONSTRAINT `fk_an_programa_aspecto_normativo`
    FOREIGN KEY (`aspecto_normativo`)
    REFERENCES `aspecto_normativo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_an_programa_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `practica_estrategia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `practica_estrategia` (
  `id` INT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `programa_pe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `programa_pe` (
  `programa` INT(10) NOT NULL,
  `practica_estrategia` INT NOT NULL,
  PRIMARY KEY (`programa`, `practica_estrategia`),
  INDEX `fk_programa_pe_practica_estrategia_idx` (`practica_estrategia`),
  INDEX `fk_programa_pe_programa_idx` (`programa`),
  CONSTRAINT `fk_programa_pe_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_programa_pe_practica_estrategia`
    FOREIGN KEY (`practica_estrategia`)
    REFERENCES `practica_estrategia` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `aa_rc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `aa_rc` (
  `activ_academicas_idcurso` INT NOT NULL,
  `registro_calificado_codigo` INT NOT NULL,
  `componente` VARCHAR(45) NOT NULL,
  `semestre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`activ_academicas_idcurso`, `registro_calificado_codigo`),
  INDEX `fk_aa_rc_registro_calificado_idx` (`registro_calificado_codigo`),
  INDEX `fk_aa_rc_activ_academica_idx` (`activ_academicas_idcurso`),
  CONSTRAINT `fk_aa_rc_activ_academica`
    FOREIGN KEY (`activ_academicas_idcurso`)
    REFERENCES `activ_academica` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aa_rc_registro_calificado`
    FOREIGN KEY (`registro_calificado_codigo`)
    REFERENCES `registro_calificado` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pasantia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasantia` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `pais` VARCHAR(45) NOT NULL,
  `empresa` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `programa` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pasantia_programa_idx` (`programa`),
  CONSTRAINT `fk_pasantia_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `premio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `premio` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `fecha` DATE NOT NULL,
  `entidad_otorgante` VARCHAR(45) NOT NULL,
  `pais` VARCHAR(45) NOT NULL,
  `programa` INT(10) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_premio_programa_idx` (`programa`),
  CONSTRAINT `fk_premio_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `car_innovacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `car_innovacion` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` LONGTEXT NOT NULL,
  `tipo` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `programa_ci`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `programa_ci` (
  `programa` INT(10) NOT NULL,
  `car_innovacion` INT NOT NULL,
  PRIMARY KEY (`programa`, `car_innovacion`),
  INDEX `fk_programa_ci_car_innovacion_idx` (`car_innovacion`),
  INDEX `fk_programa_ci_programa_idx` (`programa`),
  CONSTRAINT `fk_programa_ci_programa`
    FOREIGN KEY (`programa`)
    REFERENCES `programa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_programa_ci_car_innovacion`
    FOREIGN KEY (`car_innovacion`)
    REFERENCES `car_innovacion` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `intereses_futuros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `intereses_futuros` (
  `docente` INT(11) NOT NULL,
  `termino_clave` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`docente`, `termino_clave`),
  INDEX `fk_intereses_futuros_termino_clave_idx` (`termino_clave`),
  INDEX `fk_intereses_futuros_docente_idx` (`docente`),
  CONSTRAINT `fk_intereses_futuros_termino_clave`
    FOREIGN KEY (`docente`)
    REFERENCES `docente` (`cedula`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_intereses_futuros_docente`
    FOREIGN KEY (`termino_clave`)
    REFERENCES `termino_clave` (`termino`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
