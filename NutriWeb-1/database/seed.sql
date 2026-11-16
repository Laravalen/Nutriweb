USE nutriweb_mvp;

-- Usuários de teste (Admin, Chefs Aprovados, Chef Pendente e Clientes em Joinville e Curitiba)
INSERT INTO users (id, name, email, password, role, city, latitude, longitude, is_subscriber) VALUES
(1, 'Curadoria NutriWeb', 'admin@nutriweb.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Joinville, SC', -26.30440000, -48.84870000, 1),
(2, 'Chef Helena Mansur', 'helena@osteriamansur.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'creator', 'Joinville, SC', -26.29850000, -48.84620000, 1),
(3, 'Chef Kenji Takahashi', 'kenji@umamilab.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'creator', 'Joinville, SC', -26.31100000, -48.84200000, 1),
(4, 'Chef Lucas Mendes', 'lucas@bistrosul.com.br', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'creator', 'Joinville, SC', -26.30100000, -48.85100000, 0),
(5, 'Mariana Costa (Joinville)', 'mariana@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'Joinville, SC', -26.30500000, -48.85000000, 0),
(6, 'Rafael Souza (Curitiba - Fora do Raio)', 'rafael@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', 'Curitiba, PR', -25.42840000, -49.27330000, 1);

-- Perfis Profissionais (2 aprovados, 1 pendente na fila do Admin)
INSERT INTO creator_profiles (user_id, business_name, specialty, cnpj, alvara_number, diploma_code, sanitary_terms_accepted, delivery_radius_km, status, reviewed_by) VALUES
(2, 'Osteria Mansur', 'Cozinha Italiana Artesanal', '12.345.678/0001-90', 'ALV-SC-2026-884', 'IGP-2018-441', 1, 15, 'approved', 1),
(3, 'Umami Lab Joinville', 'Alta Gastronomia Asiática', '98.765.432/0001-10', 'ALV-SC-2026-912', 'LE-CORDON-992', 1, 12, 'approved', 1),
(4, 'Bistrô do Sul', 'Cozinha Brasileira Contemporânea', '45.111.222/0001-55', 'ALV-SC-2026-305', '', 1, 10, 'pending', NULL);

-- Receitas Exclusivas
INSERT INTO recipes (id, creator_id, title, category, dietary_restriction, difficulty, prep_time_minutes, price, included_in_club, description, ingredients, steps, zero_waste_tip, video_stream_token, rating) VALUES
(1, 2, 'Agnolotti del Plin com Manteiga de Sálvia e Nozes', 'Italiana', 'Vegetariana', 'Avançado', 65, 34.90, 1,
 'Massa fresca artesanal recheada com ricota de ovelha, espinafre branqueado e nozes tostadas.',
 "300g de farinha 00\n3 gemas caipiras\n250g de ricota fresca drenada\n80g de nozes pecã tostadas\n15 folhas de sálvia fresca\n90g de manteiga sem sal",
 "1. Misture a farinha com as gemas até obter massa lisa e deixe descansar 30 min.\n2. Processe a ricota com nozes e noz-moscada.\n3. Abra a massa fina, recheie e feche formando os plins.\n4. Cozinhe por 2 minutos e finalize na manteiga espumante com sálvia.",
 "Use os talos do espinafre branqueado em um caldo vegetal aromático para hidratar o recheio.",
 'NW-DRM-ITALIA-001', 4.9),

(2, 3, 'Ramen Tonkotsu Express com Tare de Missô Envelhecido', 'Asiática', 'Sem lactose', 'Intermediário', 45, 29.90, 1,
 'Caldo cremoso emulsificado em 45 minutos com barriga de porco braseada e ovo marinado ajitsuke.',
 "200g de macarrão alcalino para ramen\n500ml de caldo base concentrado\n2 colheres de tare de missô\n2 ovos caipiras marinados (6min30s)\n120g de chashu fatiado\nCebolinha e nori",
 "1. Aqueça o tare de missô no fundo da tigela.\n2. Adicione o caldo fervente emulsificando com fouet.\n3. Cozinhe o macarrão por 90 segundos e escorra bem.\n4. Monte com chashu maçaricado, ovo marinado e cebolinha.",
 "Aproveite as aparas da cebolinha e cascas de alho para aromatizar o óleo finalizador (mayu).",
 'NW-DRM-ASIA-002', 5.0),

(3, 2, 'Risoto de Cogumelos Silvestres e Tartufo', 'Italiana', 'Sem glúten', 'Fácil', 35, 24.90, 1,
 'Arroz Carnaroli cremoso na medida certa sem uso de creme de leite, finalizado com azeite trufado.',
 "180g de arroz Carnaroli\n200g de cogumelos frescos variados\n800ml de caldo de legumes quente\n60ml de vinho branco seco\n50g de parmesão 24 meses\n40g de manteiga gelada",
 "1. Doure os cogumelos em fogo alto e reserve.\n2. Toste o arroz por 2 minutos e deglaceie com vinho branco.\n3. Adicione o caldo aos poucos mexendo sempre por 16 minutos.\n4. Desligue o fogo e faça a mantecatura com manteiga gelada e parmesão.",
 "As bases fibrosas dos cogumelos servem como base principal do caldo de legumes da receita.",
 'NW-DRM-ITALIA-003', 4.8);

-- Kits Mise en Place (Porcionados e Higienizados)
INSERT INTO kits (id, recipe_id, creator_id, title, servings, price, sanitary_certified) VALUES
(1, 1, 2, 'Kit Mise en Place: Agnolotti del Plin (Massa + Recheio + Sálvia)', 2, 78.00, 1),
(2, 2, 3, 'Kit Mise en Place: Ramen Completo (Caldo + Tare + Chashu + Ovos)', 2, 84.50, 1),
(3, 3, 2, 'Kit Mise en Place: Risoto de Cogumelos Frescos Selecionados', 2, 69.00, 1);

-- Posts da Comunidade
INSERT INTO community_posts (recipe_id, user_id, type, content, chef_reply, rating) VALUES
(1, 5, 'result', 'Fiz para o jantar de sexta! A dica de fechar apertando bem o plin evitou que abrisse na água.', 'Ficou excelente, Mariana! O ponto da manteiga noisette faz toda a diferença.', 5),
(1, 6, 'question', 'Posso substituir a farinha 00 por farinha de trigo comum tipo 1?', NULL, 5);