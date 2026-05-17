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
('Acero', '#6FA3B8', 'acero.svg'),('Agua', '#2F80ED', 'agua.svg'),
('Bicho', '#9AA60F', 'bicho.svg'),('Dragon', '#5865E0', 'dragon.svg'),
('Electrico', '#F2B705', 'electrico.svg'),('Fantasma', '#7A4C8F', 'fantasma.svg'),
('Fuego', '#F02020', 'fuego.svg'),('Hada', '#E26BE2', 'hada.svg'),
('Hielo', '#47C7E8', 'hielo.svg'),('Lucha', '#F08000', 'lucha.svg'),
('Normal', '#A0A0A0', 'normal.svg'),('Planta', '#3FA129', 'planta.svg'),
('Psiquico', '#E64B7A', 'psiquico.svg'),('Roca', '#B8B07A', 'roca.svg'),
('Siniestro', '#4A3A3A', 'siniestro.svg'),('Tierra', '#A86B2D', 'tierra.svg'),
('Veneno', '#8A3FD1', 'veneno.svg'),('Volador', '#8CB9E8', 'volador.svg');

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
((SELECT id FROM pokemon WHERE nombre = 'Eevee'),(SELECT idTipo FROM tipo WHERE nombre = 'Normal')),
((SELECT id FROM pokemon WHERE nombre = 'Umbreon'),(SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),
((SELECT id FROM pokemon WHERE nombre = 'Blaziken'),(SELECT idTipo FROM tipo WHERE nombre = 'Fuego')),
((SELECT id FROM pokemon WHERE nombre = 'Blaziken'),(SELECT idTipo FROM tipo WHERE nombre = 'Lucha')),
((SELECT id FROM pokemon WHERE nombre = 'Gardevoir'),(SELECT idTipo FROM tipo WHERE nombre = 'Psiquico')),
((SELECT id FROM pokemon WHERE nombre = 'Gardevoir'),(SELECT idTipo FROM tipo WHERE nombre = 'Hada')),
((SELECT id FROM pokemon WHERE nombre = 'Sableye'),(SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),
((SELECT id FROM pokemon WHERE nombre = 'Sableye'),(SELECT idTipo FROM tipo WHERE nombre = 'Fantasma')),
((SELECT id FROM pokemon WHERE nombre = 'Garchomp'),(SELECT idTipo FROM tipo WHERE nombre = 'Dragon')),
((SELECT id FROM pokemon WHERE nombre = 'Garchomp'),(SELECT idTipo FROM tipo WHERE nombre = 'Tierra')),
((SELECT id FROM pokemon WHERE nombre = 'Hydreigon'),(SELECT idTipo FROM tipo WHERE nombre = 'Siniestro')),
((SELECT id FROM pokemon WHERE nombre = 'Hydreigon'),(SELECT idTipo FROM tipo WHERE nombre = 'Dragon')),
((SELECT id FROM pokemon WHERE nombre = 'Sylveon'),(SELECT idTipo FROM tipo WHERE nombre = 'Hada')),
((SELECT id FROM pokemon WHERE nombre = 'Lycanroc'),(SELECT idTipo FROM tipo WHERE nombre = 'Roca')),
((SELECT id FROM pokemon WHERE nombre = 'Zacian'),(SELECT idTipo FROM tipo WHERE nombre = 'Hada')),
((SELECT id FROM pokemon WHERE nombre = 'Zacian'),(SELECT idTipo FROM tipo WHERE nombre = 'Acero'));

INSERT INTO Pokemon (idNoIncremental, dirImagen, nombre, descripcion, habilidad1, habilidad2, habilidad3) VALUES
(9, 'blastoise.png', 'Blastoise','Pokémon con potentes cañones de agua en su caparazón capaces de perforar acero.','Torrente', 'Cura Lluvia', NULL),
(1, 'bulbasaur.png', 'Bulbasaur','Pokémon semilla que lleva una planta en su lomo desde que nace.','Espesura', 'Clorofila', NULL),
(6, 'charizard.png', 'Charizard','Escupe fuego tan caliente que puede derretir cualquier cosa.','Mar Llamas', 'Poder Solar', NULL),
(4, 'charmander.png', 'Charmander','La llama de su cola indica sus emociones y estado de salud.','Mar Llamas', 'Poder Solar', NULL),
(104, 'cubone.png', 'Cubone','Usa el cráneo de su madre fallecida como casco.','Cabeza Roca', 'Pararrayos', 'Armadura Batalla'),
(39, 'jigglypuff.png', 'Jigglypuff','Su canto provoca sueño en quienes lo escuchan.','Gran Encanto', 'Competitivo', 'Amigo Guardia'),
(129, 'magikarp.png', 'Magikarp','Pokémon extremadamente débil que solo sabe salpicar.','Nado Rápido', 'Cobardía', NULL),
(52, 'meowth.png', 'Meowth','Adora los objetos brillantes y las monedas.','Recogida', 'Experto', 'Nerviosismo'),
(151, 'mew.png', 'Mew','Se dice que posee el ADN de todos los Pokémon.','Sincronía', NULL, NULL),
(150, 'mewtwo.png', 'Mewtwo','Pokémon creado mediante manipulación genética.','Presión', 'Nerviosismo', NULL),
(95, 'onix.png', 'Onix','Excava a gran velocidad bajo tierra buscando alimento.','Cabeza Roca', 'Robustez', 'Armadura Frágil'),
(25, 'pikachu.png', 'Pikachu','Almacena electricidad en sus mejillas y la libera en combate.','Electricidad Estática', 'Pararrayos', NULL),
(54, 'psyduck.png', 'Psyduck','Sufre constantes dolores de cabeza que liberan poderes psíquicos.','Humedad', 'Aclimatación', 'Nado Rápido'),
(26, 'raichu.png', 'Raichu','Puede liberar descargas eléctricas de más de 100000 voltios.','Electricidad Estática', 'Pararrayos', NULL),
(143, 'snorlax.png', 'Snorlax','Pokémon dormilón que solo despierta para comer.','Inmunidad', 'Sebo', 'Gula'),
(7, 'squirtle.png', 'Squirtle','Su caparazón le sirve tanto de protección como para nadar velozmente.','Torrente', 'Cura Lluvia', NULL),
(68, 'machamp.png', 'Machamp','Utiliza sus cuatro brazos para lanzar golpes devastadores.','Agallas', 'Indefenso', 'Impasible'),
(110, 'weezing.png', 'Weezing','Pokémon gas formado por la unión de dos cuerpos llenos de gases tóxicos.','Levitación', 'Gas Reactivo', 'Hedor'),
(24, 'arbok.png', 'Arbok','Pokémon cobra con un patrón intimidante en el pecho que paraliza a sus enemigos.','Intimidación', 'Mudar', 'Nerviosismo'),
(92, 'gastly.png', 'Gastly','Pokémon gas compuesto casi totalmente por gases venenosos.','Levitación', NULL, NULL),
(94, 'gengar.png', 'Gengar','Pokémon sombra que acecha en la oscuridad y absorbe el calor corporal de sus víctimas.','Cuerpo Maldito', NULL, NULL),
(107, 'hitmonchan.png', 'Hitmonchan','Pokémon boxeador con golpes veloces capaces de superar la velocidad del sonido.','Vista Lince', 'Puño Férreo', 'Impasible'),
(18, 'pidgeot.png', 'Pidgeot','Pokémon ave con una gran velocidad de vuelo y excelentes reflejos.','Vista Lince', 'Tumbos', 'Intrépido'),
(57, 'primeape.png', 'Primeape','Pokémon mono extremadamente agresivo que se enfurece con facilidad.','Espíritu Vital', 'Irascible', 'Competitivo');

INSERT INTO Pokemon_tipo(pokemonId,tipoId) VALUES
((SELECT id FROM pokemon WHERE nombre = 'Blastoise'),(SELECT idTipo FROM tipo WHERE nombre = 'Agua')),
((SELECT id FROM pokemon WHERE nombre = 'Bulbasaur'),(SELECT idTipo FROM tipo WHERE nombre = 'Planta')),
((SELECT id FROM pokemon WHERE nombre = 'Bulbasaur'),(SELECT idTipo FROM tipo WHERE nombre = 'Veneno')),
((SELECT id FROM pokemon WHERE nombre = 'Charizard'),(SELECT idTipo FROM tipo WHERE nombre = 'Fuego')),
((SELECT id FROM pokemon WHERE nombre = 'Charizard'),(SELECT idTipo FROM tipo WHERE nombre = 'Volador')),
((SELECT id FROM pokemon WHERE nombre = 'Charmander'),(SELECT idTipo FROM tipo WHERE nombre = 'Fuego')),
((SELECT id FROM pokemon WHERE nombre = 'Cubone'),(SELECT idTipo FROM tipo WHERE nombre = 'Tierra')),
((SELECT id FROM pokemon WHERE nombre = 'Jigglypuff'),(SELECT idTipo FROM tipo WHERE nombre = 'Normal')),
((SELECT id FROM pokemon WHERE nombre = 'Jigglypuff'),(SELECT idTipo FROM tipo WHERE nombre = 'Hada')),
((SELECT id FROM pokemon WHERE nombre = 'Magikarp'),(SELECT idTipo FROM tipo WHERE nombre = 'Agua')),
((SELECT id FROM pokemon WHERE nombre = 'Meowth'),(SELECT idTipo FROM tipo WHERE nombre = 'Normal')),
((SELECT id FROM pokemon WHERE nombre = 'Mew'),(SELECT idTipo FROM tipo WHERE nombre = 'Psiquico')),
((SELECT id FROM pokemon WHERE nombre = 'Mewtwo'),(SELECT idTipo FROM tipo WHERE nombre = 'Psiquico')),
((SELECT id FROM pokemon WHERE nombre = 'Onix'),(SELECT idTipo FROM tipo WHERE nombre = 'Roca')),
((SELECT id FROM pokemon WHERE nombre = 'Onix'),(SELECT idTipo FROM tipo WHERE nombre = 'Tierra')),
((SELECT id FROM pokemon WHERE nombre = 'Pikachu'),(SELECT idTipo FROM tipo WHERE nombre = 'Electrico')),
((SELECT id FROM pokemon WHERE nombre = 'Psyduck'),(SELECT idTipo FROM tipo WHERE nombre = 'Agua')),
((SELECT id FROM pokemon WHERE nombre = 'Raichu'),(SELECT idTipo FROM tipo WHERE nombre = 'Electrico')),
((SELECT id FROM pokemon WHERE nombre = 'Snorlax'),(SELECT idTipo FROM tipo WHERE nombre = 'Normal')),
((SELECT id FROM pokemon WHERE nombre = 'Squirtle'),(SELECT idTipo FROM tipo WHERE nombre = 'Agua')),
((SELECT id FROM pokemon WHERE nombre = 'Machamp'),(SELECT idTipo FROM tipo WHERE nombre = 'Lucha')),
((SELECT id FROM pokemon WHERE nombre = 'Weezing'),(SELECT idTipo FROM tipo WHERE nombre = 'Veneno')),
((SELECT id FROM pokemon WHERE nombre = 'Arbok'),(SELECT idTipo FROM tipo WHERE nombre = 'Veneno')),
((SELECT id FROM pokemon WHERE nombre = 'Gastly'),(SELECT idTipo FROM tipo WHERE nombre = 'Fantasma')),
((SELECT id FROM pokemon WHERE nombre = 'Gastly'),(SELECT idTipo FROM tipo WHERE nombre = 'Veneno')),
((SELECT id FROM pokemon WHERE nombre = 'Gengar'),(SELECT idTipo FROM tipo WHERE nombre = 'Fantasma')),
((SELECT id FROM pokemon WHERE nombre = 'Gengar'),(SELECT idTipo FROM tipo WHERE nombre = 'Veneno')),
((SELECT id FROM pokemon WHERE nombre = 'Hitmonchan'),(SELECT idTipo FROM tipo WHERE nombre = 'Lucha')),
((SELECT id FROM pokemon WHERE nombre = 'Pidgeot'),(SELECT idTipo FROM tipo WHERE nombre = 'Normal')),
((SELECT id FROM pokemon WHERE nombre = 'Pidgeot'),(SELECT idTipo FROM tipo WHERE nombre = 'Volador')),
((SELECT id FROM pokemon WHERE nombre = 'Primeape'),(SELECT idTipo FROM tipo WHERE nombre = 'Lucha'));