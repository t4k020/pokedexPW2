create database pokedex;
use pokedex;

CREATE TABLE Tipo (
    idTipo int auto_increment primary key,
    nombre varchar(15),
    dirImagen varchar(100),
    color varchar(8)
);

create table pokemon(
    id int auto_increment primary key,
    idNoIncremental int,
    dirImagen varchar(100),
    nombre varchar(40),
    tipo1 varchar(30),
    tipo2 varchar(30),
    descripcion text,
    habilidad1 varchar(50),
    habilidad2 varchar(50),
    habilidad3 varchar(50)
   );

INSERT INTO Tipo (nombre, color, dirImagen) VALUES
('ACERO', '#6FA3B8', 'steel.svg'),('AGUA', '#2F80ED', 'water.svg'),
('BICHO', '#9AA60F', 'bug.svg'),('DRAGÓN', '#5865E0', 'dragon.svg'),
('ELECTRICO', '#F2B705', 'electric.svg'),('FANTASMA', '#7A4C8F', 'ghost.svg'),
('FUEGO', '#F02020', 'fire.svg'),('HADA', '#E26BE2', 'fairy.svg'),
('HIELO', '#47C7E8', 'ice.svg'),('LUCHA', '#F08000', 'fighting.svg'),
('NORMAL', '#A0A0A0', 'normal.svg'),('PLANTA', '#3FA129', 'grass.svg'),
('PSIQUICO', '#E64B7A', 'psychic.svg'),('ROCA', '#B8B07A', 'rock.svg'),
('SINIESTRO', '#4A3A3A', 'dark.svg'),('TIERRA', '#A86B2D', 'ground.svg'),
('VENENO', '#8A3FD1', 'poison.svg'),('VOLADOR', '#8CB9E8', 'flying.svg');

INSERT INTO pokemon (idNoIncremental, dirImagen, nombre, tipo1, tipo2, descripcion, habilidad1, habilidad2, habilidad3) VALUES
(133, 'eevee.png', 'Eevee', 'Normal', NULL, 'Su estructura genética es irregular y puede mutar por diversas causas, permitiéndole evolucionar.', 'Run Away', 'Adaptability', 'Anticipation'),
(197, 'umbreon.png', 'Umbreon', 'Dark', NULL, 'Cuando se expone al aura lunar, los anillos de su cuerpo brillan y se llena de una energía misteriosa.', 'Synchronize', 'Inner Focus', NULL),
(257, 'blaziken.png', 'Blaziken', 'Fire', 'Fighting', 'En combate, exhala intensas llamas por las muñecas y ataca con una ferocidad increíble.', 'Blaze', 'Speed Boost', NULL),
(282, 'gardevoir.png', 'Gardevoir', 'Psychic', 'Fairy', 'Tiene la capacidad de predecir el futuro para proteger a su entrenador con su máximo poder.', 'Synchronize', 'Trace', 'Telepathy'),
(302, 'sableye.png', 'Sableye', 'Dark', 'Ghost', 'Vive en cuevas profundas. Se alimenta de gemas, por lo que sus ojos se convirtieron en joyas.', 'Keen Eye', 'Stall', 'Prankster'),
(445, 'garchomp.png', 'Garchomp', 'Dragon', 'Ground', 'Vuela a una velocidad increíble. Sus alas crean cuchillas de aire cuando corre a potencia.', 'Sand Veil', 'Rough Skin', NULL),
(635, 'hydreigon.png', 'Hydreigon', 'Dark', 'Dragon', 'Pokémon aterrador con tres cabezas. Solo la cabeza del centro tiene cerebro.', 'Levitate', NULL, NULL),
(700, 'sylveon.png', 'Sylveon', 'Fairy', NULL, 'A través de sus cintas sensoriales, emite un aura relajante que detiene cualquier combate.', 'Cute Charm', 'Pixilate', NULL),
(745, 'lycanron.png', 'Lycanroc', 'Rock', NULL, 'Su forma depende de la posición del sol o la luna. Es un cazador rápido y feroz.', 'Keen Eye', 'Sand Rush', 'Steadfast'),
(888, 'zacian.png', 'Zacian', 'Fairy', 'Steel', 'Conocido como el héroe de la leyenda, capaz de cortar cualquier cosa con su espada.', 'Intrepid Sword', NULL, NULL);