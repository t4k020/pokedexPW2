create database pokedex;
use pokedex;

CREATE TABLE Usuario (
    id INT PRIMARY KEY ,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE Tipo (
    idTipo int auto_increment primary key,
    nombre varchar(15) unique,
    dirImagen varchar(100),
    color varchar(8)
);

create table Pokemon(
    id int auto_increment primary key,
    idNoIncremental int unique,
    dirImagen varchar(100),
    nombre varchar(40) unique,
    descripcion text,
    habilidad1 varchar(50),
    habilidad2 varchar(50),
    habilidad3 varchar(50)
   );

CREATE TABLE Pokemon_tipo(
    pokemonId INT,
    tipoId INT,
    PRIMARY KEY(pokemonId, tipoId),
    FOREIGN KEY(pokemonId) REFERENCES pokemon(id),
    FOREIGN KEY(tipoId) REFERENCES tipo(idTipo)
);

insert into Usuario (id,username,password)
values (1,'admin','123');

INSERT INTO Tipo (nombre, color, dirImagen) VALUES
('Acero', '#6FA3B8', 'acero.svg'),          ('Agua', '#2F80ED', 'agua.svg'),
('Bicho', '#9AA60F', 'bicho.svg'),          ('Dragon', '#5865E0', 'dragon.svg'),
('Electrico', '#F2B705', 'electrico.svg'),  ('Fantasma', '#7A4C8F', 'fantasma.svg'),
('Fuego', '#F02020', 'fuego.svg'),          ('Hada', '#E26BE2', 'hada.svg'),
('Hielo', '#47C7E8', 'hielo.svg'),          ('Lucha', '#F08000', 'lucha.svg'),
('Normal', '#A0A0A0', 'normal.svg'),        ('Planta', '#3FA129', 'planta.svg'),
('Psiquico', '#E64B7A', 'psiquico.svg'),    ('Roca', '#B8B07A', 'roca.svg'),
('Siniestro', '#4A3A3A', 'siniestro.svg'),  ('Tierra', '#A86B2D', 'tierra.svg'),
('Veneno', '#8A3FD1', 'veneno.svg'),        ('Volador', '#8CB9E8', 'volador.svg');

INSERT INTO Pokemon (idNoIncremental, dirImagen, nombre, descripcion, habilidad1, habilidad2, habilidad3) VALUES
(133, 'eevee.png', 'Eevee', 'Su estructura genética es irregular y puede mutar por diversas causas, permitiéndole evolucionar.', 'Run Away', 'Adaptability', 'Anticipation'),
(197, 'umbreon.png', 'Umbreon', 'Cuando se expone al aura lunar, los anillos de su cuerpo brillan y se llena de una energía misteriosa.', 'Synchronize', 'Inner Focus', NULL),
(257, 'blaziken.png', 'Blaziken', 'En combate, exhala intensas llamas por las muñecas y ataca con una ferocidad increíble.', 'Blaze', 'Speed Boost', NULL),
(282, 'gardevoir.png', 'Gardevoir', 'Tiene la capacidad de predecir el futuro para proteger a su entrenador con su máximo poder.', 'Synchronize', 'Trace', 'Telepathy'),
(302, 'sableye.png', 'Sableye', 'Vive en cuevas profundas. Se alimenta de gemas, por lo que sus ojos se convirtieron en joyas.', 'Keen Eye', 'Stall', 'Prankster'),
(445, 'garchomp.png', 'Garchomp', 'Vuela a una velocidad increíble. Sus alas crean cuchillas de aire cuando corre a potencia.', 'Sand Veil', 'Rough Skin', NULL),
(635, 'hydreigon.png', 'Hydreigon', 'Pokémon aterrador con tres cabezas. Solo la cabeza del centro tiene cerebro.', 'Levitate', NULL, NULL),
(700, 'sylveon.png', 'Sylveon', 'A través de sus cintas sensoriales, emite un aura relajante que detiene cualquier combate.', 'Cute Charm', 'Pixilate', NULL),
(745, 'lycanron.png', 'Lycanroc', 'Su forma depende de la posición del sol o la luna. Es un cazador rápido y feroz.', 'Keen Eye', 'Sand Rush', 'Steadfast'),
(888, 'zacian.png', 'Zacian', 'Conocido como el héroe de la leyenda, capaz de cortar cualquier cosa con su espada.', 'Intrepid Sword', NULL, NULL);

INSERT INTO Pokemon_tipo(pokemonId,tipoId) VALUES
((SELECT id FROM pokemon WHERE nombre = 'Eevee'),     (SELECT idTipo FROM tipo WHERE nombre = 'Normal')),

((SELECT id FROM pokemon WHERE nombre = 'Umbreon'),   (SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),

((SELECT id FROM pokemon WHERE nombre = 'Blaziken'),  (SELECT idTipo FROM tipo WHERE nombre = 'Fuego')),
((SELECT id FROM pokemon WHERE nombre = 'Blaziken'),  (SELECT idTipo FROM tipo WHERE nombre = 'Lucha')),

((SELECT id FROM pokemon WHERE nombre = 'Gardevoir'), (SELECT idTipo FROM tipo WHERE nombre = 'Psiquico')),
((SELECT id FROM pokemon WHERE nombre = 'Gardevoir'), (SELECT idTipo FROM tipo WHERE nombre = 'Hada')),

((SELECT id FROM pokemon WHERE nombre = 'Sableye'),   (SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),
((SELECT id FROM pokemon WHERE nombre = 'Sableye'),   (SELECT idTipo FROM tipo WHERE nombre = 'Fantasma')),

((SELECT id FROM pokemon WHERE nombre = 'Garchomp'),  (SELECT idTipo FROM tipo WHERE nombre = 'Dragon')),
((SELECT id FROM pokemon WHERE nombre = 'Garchomp'),  (SELECT idTipo FROM tipo WHERE nombre = 'Tierra')),

((SELECT id FROM pokemon WHERE nombre = 'Hydreigon'), (SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),
((SELECT id FROM pokemon WHERE nombre = 'Hydreigon'), (SELECT idTipo FROM tipo WHERE nombre = 'Dragon')),

((SELECT id FROM pokemon WHERE nombre = 'Sylveon'),   (SELECT idTipo FROM tipo WHERE nombre = 'Hada')),

((SELECT id FROM pokemon WHERE nombre = 'Lycanroc'),  (SELECT idTipo FROM tipo WHERE nombre = 'Roca')),

((SELECT id FROM pokemon WHERE nombre = 'Zacian'),    (SELECT idTipo FROM tipo WHERE nombre = 'Hada')),
((SELECT id FROM pokemon WHERE nombre = 'Zacian'),    (SELECT idTipo FROM tipo WHERE nombre = 'Acero'));