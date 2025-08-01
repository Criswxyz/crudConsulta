--Despejando dados para a tabela `consultas`

INSERT INTO `consultas` (`id`, `medico_id`, `paciente_id`, `data_hora`, `observacao`) VALUES
(5, 3, 1, '2025-06-14 17:30:00', 'déficits neurológicos'),
(6, 3, 6, '2025-06-18 19:20:00', 'QI muito elevado'),
(7, 4, 8, '2025-05-14 16:25:00', 'Frequência cardíaca estável');


--Despejando dados para a tabela `medicos`

INSERT INTO `medicos` (`id`, `nome`, `especialidade`, `usuario_id`) VALUES
(3, 'nelio', 'Neurologia', 3),
(4, 'john', 'Cardiolodia', 5);


 --Despejando dados para a tabela `pacientes`

INSERT INTO `pacientes` (`id`, `nome`, `data_nascimento`, `tipo_sanguineo`, `usuario_id`) VALUES
(1, 'alexandre', '1999-03-20', 'A-', 2),
(6, 'cristiano', '2006-01-19', 'AB+', 1),
(8, 'pedro', '2003-09-27', 'O-', 4);


--Despejando dados para a tabela `usuarios`

INSERT INTO `usuarios` (`id`, `username`, `password`) VALUES
(1, 'cristiano', '$2y$10$Ao24dmrPfoFb68GC.RhTS.NfosRqAiKxutlhSSG14vbyI49bIHFn6'),
(2, 'alexandre', '$2y$10$Tv1dd2Qj5BdetvxtcIiGuexNjeXUMoRQnEVhuKGY3ioED/22.Xhc2'),
(3, 'nelio', '$2y$10$JYw3lGEOOqP8Fv5AFrWdR.b5.eMiNNf6J9tmiqCINLv4rZe8/I1JG'),
(4, 'pedro', '$2y$10$rV6BA4pNtd5yNRzSwaY1yeaMWWIPYPnbVRXfxydmOeBDMeh2DKG3q'),
(5, 'john', '$2y$10$8YwdzQiv8gRkPfMobWLfx.E1axTFQQ5RJcwLK.CMhljE7a9Eykc1a');


