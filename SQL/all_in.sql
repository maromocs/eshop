CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY, 
  email VARCHAR(255) NOT NULL,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(10) NOT NULL,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert the first user with a specific ID
INSERT INTO user (id, email, username, password, role)
VALUES (1, 'game@flix.com', 'GameFlix', '55de85e2f4a1560978c9dd479550c840', 'seller');

-- After inserting the first user, set the auto-increment value to 2
ALTER TABLE user AUTO_INCREMENT = 2;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    photo VARCHAR(255),
    type ENUM('code', 'merch', 'game', 'wallpaper', 'figure', 'plushie') NOT NULL,
    seller_id INT NOT NULL, 
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES user(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE basket (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE ordered_products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) GENERATED ALWAYS AS (quantity * price) STORED,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Insert Products into `products` table
INSERT INTO products (name, description, price, photo, type, seller_id) VALUES
-- A
('Assassin’s Creed Odyssey Poster', 'Official poster from Assassin’s Creed Odyssey.', 19.99, 'https://m.media-amazon.com/images/I/81c8SRTpiIL._AC_UF894,1000_QL80_.jpg', 'poster', 1),
('Animal Crossing Plushie', 'Tom Nook plushie from Animal Crossing.', 25.99, 'https://store.nintendo.co.za/cdn/shop/products/1307-AnimalCrossingIsabelle8_Plush_1_1200x1200_crop_center.png?v=1636615162', 'plushie', 1),
('Among Us Figure', 'Crewmate figure from Among Us.', 15.00, 'https://justtoysintl.com/wp-content/uploads/2023/05/among-us-mini-figures-series-2-collection.jpg', 'figure', 1),
('Apex Legends Code', 'Coins code for Apex Legends.', 9.99, 'https://images-na.ssl-images-amazon.com/images/I/41luYJyKiLL.jpg', 'code', 1),
('Ark Survival Wallpaper', 'Wallpaper from Ark Survival Evolved.', 4.99, 'https://i.redd.it/y3c0nfr4hpiz.jpg', 'wallpaper', 1),
('Arcane League of Legends PULASSI - Women`s and Men`s Y2k Hoodie', 'Hoodie for League of Legends Season 2 Sweatshirts, Streetwear Hoodies', 26.99, 'https://m.media-amazon.com/images/I/611EgLieIZL._AC_SX679_.jpg', 'merch', 1),
-- B
('Battlefield Game Code', 'Battlefield game activation code.', 49.99, 'https://m.media-amazon.com/images/I/91rw1hfQ33L._AC_UF894,1000_QL80_.jpg', 'code', 1),
('Bioshock Infinite Poster', 'Artwork poster from Bioshock Infinite.', 14.99, 'https://m.media-amazon.com/images/M/MV5BMTU3NTYwNDg0NV5BMl5BanBnXkFtZTcwNzAxMTQ2OA@@._V1_.jpg', 'poster', 1),
('Borderlands 3 Plush', 'Psycho Keychain plushie from Borderlands 3.', 9.99, 'https://m.media-amazon.com/images/I/513fQpv27BL._SL1000_.jpg', 'plushie', 1),
('Breath of the Wild Wallpaper', 'Scenic wallpaper from Zelda: Breath of the Wild.', 15.99, 'https://zelda.nintendo.com/breath-of-the-wild/assets/media/wallpapers/desktop-1.jpg', 'wallpaper', 1),
('Bloodborne: The Old Hunters: Lady Maria of The Astral Clocktower', 'Deluxe Figma Action Figure 16 cm/6.3 Inch PVC Film Character Model Anime Statue Toy Collectibles Gifts.', 33.50, 'https://m.media-amazon.com/images/I/616nJEciobL._AC_SL1000_.jpg', 'figure', 1),
-- C
('Cyberpunk 2077 Metal Poster', 'Cyberpunk 2077 Decorative Cyberpunk 2077 Poster Cyberpunk 2077 - Ultimate Edition Ultimate Edition Key Art Poster 32 x 45 cm.', 19.99, 'https://m.media-amazon.com/images/I/71Fhz8mtQCL._AC_SL1500_.jpg', 'poster', 1),
('Call of Duty Black Ops 2 : Game Code', 'Game code for Call of Duty: Black Ops 2.', 49.99, 'https://upload.wikimedia.org/wikipedia/en/thumb/0/05/Call_of_Duty_Black_Ops_II_box_artwork.png/220px-Call_of_Duty_Black_Ops_II_box_artwork.png', 'code', 1),
('Crash Bandicoot Plush', 'Original Symbol of Victory Cheering Official Video Game Activision - Orange - 32cm.', 15.59, 'https://m.media-amazon.com/images/I/51DnU5+KQ8L._AC_SL1050_.jpg', 'plushie', 1),
('Cuphead Bobbling Figurine', 'Cuphead figurine from the game with sound!', 13.99, 'https://m.media-amazon.com/images/I/717nlj3Hb+L._AC_SL1500_.jpg', 'figure', 1),
('Celeste Wallpaper', 'Pixel-art wallpaper from Celeste.', 9.99, 'https://images7.alphacoders.com/901/901149.png', 'wallpaper', 1),
-- D
('Doom Eternal Game Code', 'Activation code for Doom Eternal.', 45.99, 'https://upload.wikimedia.org/wikipedia/en/9/9d/Cover_Art_of_Doom_Eternal.png', 'code', 1),
('Dark Souls Pullover Hoodie, black', 'PRAISE THE SUN! Dark Souls Hoodie.', 44.99, 'https://m.media-amazon.com/images/I/B1mEhjGJ2nL._CLa%7C2140%2C2000%7CB1NZbtQRz%2BL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX466_.png', 'merch', 1),
('Destiny 2 Ghost Plushie', 'Numskull Official Generalist Shell Plush Soft Replica Cuddly Toy Official Destiny 2 Merchandise.', 24.99, 'https://m.media-amazon.com/images/I/819NFHqybeL._AC_SL1500_.jpg', 'plushie', 1),
('Diablo Blizzard Figure', 'Blizzard Diablo IV - Red Lilith 30.5.', 129.99, 'https://m.media-amazon.com/images/I/61WHFPGLfDL._AC_SL1080_.jpg', 'figure', 1),
('Darius Unlocked Figure', 'I do not tolerate cowardice. Commander of the Trifarian Legion, Darius cleaves through the enemies of the Noxian empire with his massive battle axe.', 89.99, 'https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products%2F234f1b5de41d7c94b02a03b8c37ea14ca498ba01-2560x3200.png&w=828&q=75', 'figure', 1),
-- E 
('Elden Ring Poster', 'Official artwork poster from Elden Ring.', 19.99, 'https://i.ebayimg.com/images/g/oyEAAOSwIBdijBIx/s-l1200.jpg', 'poster', 1),
('EarthBound Official Chosen Four Plush', 'Ness plushie from EarthBound.', 4.99, 'https://www.1101.com/mother_project/items/img/friends/pic_11.jpg', 'plushie', 1),
('Eve Online Code', '1-month subscription code for Eve Online.', 9.99, 'https://cdn2.unrealengine.com/eve-online-1920x1080-63abdd7114f4.png', 'code', 1),
('Eternal Sonata Wallpaper', 'Scenic wallpaper from Eternal Sonata.', 4.99, 'https://i.ytimg.com/vi/3MErjEYEjzw/maxresdefault.jpg', 'wallpaper', 1),
('Enter the Gungeon Figure', 'Bulletkin figure from Enter the Gungeon.', 14.99, 'https://i.ebayimg.com/images/g/w-kAAOSwtFpkAZqn/s-l400.jpg', 'plushie', 1),
-- F
('Final Fantasy Poster', 'Final Poster Fantasy Role Play Vintage Video Game Poster Print Painting for Bedroom Canvas Wall Art Aesthetic Decorative 30x45cm Unframed.', 13.99, 'https://m.media-amazon.com/images/I/61UCEZm6UQL._AC_SL1500_.jpg', 'poster', 1),
('Fallout Vault Boy Plushie', 'Vault Boy plushie from Fallout.', 22.99, 'https://m.media-amazon.com/images/I/6197V-H0U9L._SL1499_.jpg', 'plushie', 1),
('Far Cry 5 Wallpaper', 'Nature-themed wallpaper from Far Cry 5.', 13.99, 'https://gameranx.com/wp-content/uploads/2017/12/Far-Cry-5-1080P-Wallpaper.jpg', 'wallpaper', 1),
('FIFA Game Code', 'FIFA game activation code.', 59.99, 'https://www.fifa-fc.com/wp-content/uploads/2024/09/EA-SPORTS-FC-25-Standard-Edition-PCWin-Downloading-Full-Game.jpg', 'code', 1),
('Fall Guys Game Code', 'Fall Guys: Ultimate Knockout game activation code.', 19.99, 'https://m.media-amazon.com/images/I/51A5vl0M7eL._AC_SL1000_.jpg', 'code', 1),

-- G
('Ghost of Tsushima Merch', 'Ghost of Tsushima Tshirt for Men', 23.99, 'https://m.media-amazon.com/images/I/B1pppR4gVKL._CLa%7C2140%2C2000%7C81cOa7WEi%2BL.png%7C0%2C0%2C2140%2C2000%2B0.0%2C0.0%2C2140.0%2C2000.0_AC_SX466_.png', 'merch', 1),
('Gran Turismo Keychain', 'Gran Turismo Official Keychain, High-quality material.', 12.99, 'https://m.media-amazon.com/images/I/310XtziJx1L._AC_.jpg', 'merch', 1),
('Gears of War Poster', 'Gears of War: Ultimate Edition Poster', 16.99, 'https://m.media-amazon.com/images/I/71+UhDOenuL._AC_SL1500_.jpg', 'poster', 1),
('Gotham Knights Figure', 'Gotham Knights 4'' (10 cm) action figure.', 19.99, 'https://m.media-amazon.com/images/I/71UXzhyGilL._AC_SL1500_.jpg', 'figure', 1),
('Granblue Fantasy Poster', 'Granblue Fantasy: The Animation Official Poster', 9.99, 'https://m.media-amazon.com/images/I/91Te9dBsr4L._AC_SL1500_.jpg', 'poster', 1),

-- H 
('Halo Infinite Poster', 'Halo Infinite promotional poster.', 15.99, 'https://m.media-amazon.com/images/I/81YMKsZX8ZL.jpg', 'poster', 1),
('Hollow Knight Plushie', 'Hollow Plush Toy, Hollow Plush Anime Doll Toy, Plush Stuffed Cushion, Plush Cushion for Anime Fans Collection Gifts.', 19.99, 'https://m.media-amazon.com/images/I/51ViyN3UZvL._AC_SL1001_.jpg', 'plushie', 1),
('Hades Game Code', 'Activation code for Hades.', 24.99, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0RhhR7mdUFkSdfzqcZ9SEK2MecrXAOWAluAHuQ1Tp2uDTEHANBqknC-zKGTxlJmuSUVgW', 'code', 1),
('Horizon Zero Dawn Wallpaper', 'Landscape wallpaper from Horizon Zero Dawn.', 35.99, 'https://www.savingcontent.com/wp-content/uploads/2024/10/HorizonZeroDawnRemastered-review_featured.png', 'wallpaper', 1),
('Hitman Figure', 'Agent 47 figure.', 31.99, 'https://cdn.zatu.com/wp-content/uploads/2020/06/18044426/Hitman-Statue-Agent-47-500x500.jpg', 'figure', 1),

-- I 
('Injustice Game Code', 'Activation code for Injustice 2.', 49.99, 'https://m.media-amazon.com/images/M/MV5BZWI5ZDhjMmItMGZiZi00M2VlLTgxMmMtNDIzZDg0Njk2NmE3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg', 'code', 1),
('It Takes Two Wallpaper', 'Wallpaper featuring characters from It Takes Two.', 4.99, 'https://wallpapers.com/images/featured/it-takes-two-l2xz4tkaq1d4na24.jpg', 'wallpaper', 1),
('Irelia Unlocked Statue', '"Let them come! This land will be their graveyard!" Special Edition PROJECT: Irelia is now Unlocked!', 85.00, 'https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products_live%2F6bb5f2c67b40bc7c7b3dfdeff19ef90bd2e396a6-2560x2560.png&w=828&q=75', 'figure', 1),

-- J 
('Jhin`s Mask', 'I am the singer without a voice. The dancer without legs. Jhin`s Mask from League of Legends', 44.44, 'https://i.etsystatic.com/22563719/r/il/40edbd/3643490185/il_fullxfull.3643490185_arin.jpg', 'mask', 1),
('Just Dance Game Code', 'Activation code for Just Dance 2024.', 39.99, 'https://storage.googleapis.com/bionic_1626848719/products/6b5dab2d44f1866776d49258483cc99c2e9dbdfe/banners/18700448_1721032467.jpg', 'code', 1),

-- K 
('Kingdom Hearts Poster', 'Poster featuring Sora from Kingdom Hearts.', 17.99, 'https://i.ebayimg.com/00/s/MTUzMFg5OTA=/z/PbgAAOSwXyRiCnWn/$_57.JPG?set_id=8800005007', 'poster', 1),
('Kirby Plushie', 'Kirby Kirby Plush Doll (M) Standard.', 16.99, 'https://m.media-amazon.com/images/I/61LV3euruwL._AC_SL1500_.jpg', 'plushie', 1),
('Katarina Unlocked Statue', 'Ready for trouble? Kat doesn`t care if you are ready or not. Katarina is now Unlocked.', 85.99, 'https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products%2F496e62565cb0e4ff023a8c7e4739f16b06ff35e6-800x1000.png&w=828&q=75', 'figure', 1),
('Kai`sa Figure', 'Join the Daughter of the Void as she keeps the Void`s hunger at bay and guards Runeterra with PureArts Kai`Sa 1/4 Scale Statue!', 849.99, 'https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products%2F1c63f3a3bcc7b85ae52887a0da1d25907bad7042-2560x2560.png&w=640&q=75', 'figure', 1),

-- L  
('League of Legends K/DA Poster', 'K/DA Popstars Poster featuring Ahri Akali Evelynn and Kai`sa.', 18.99, 'https://static1.thegamerimages.com/wordpress/wp-content/uploads/2022/06/KDA-THE-BADDEST-Cover-3-1.jpg', 'poster', 1),
('Lee Sin Unlocked Statue', '"Where am I needed?" The Blind Monk leaps into the Unlocked statue line as #08..', 75.00, 'https://merch.riotgames.com/_next/image/?url=https%3A%2F%2Fcdn.sanity.io%2Fimages%2Fdsfx7636%2Fconsumer_products_live%2F807aa6c7dd82513632c381a9078037b87fe1c61d-1000x1250.png&w=828&q=75', 'figure', 1),
('Legends of Runeterra Wallpaper', 'Legends of Runeterra Cithria the symbol of freedom wallpaper.', 29.99, 'https://www.gamewallpapers.com/download.php?img=wallpaper_legends_of_runeterra_02_1920x1080.jpg', 'wallpaper', 1),
('Lulu Plushie', 'League of Legends Game Figures, LOL Series Figures/Lulu Plush Doll, Exquisite and Lovely Shape, Can Be Used As A Showcase Collection Or The Best Gift.', 14.99, 'https://m.media-amazon.com/images/I/61vbP3hyMdL._AC_SL1024_.jpg', 'plushie', 1),

-- M  
('Minecraft Boys` Hoodie', 'Creeper? Oh man! Creeper Hoodie for boys.', 26.99, 'https://m.media-amazon.com/images/I/61bY1Naw7lL._AC_SX679_.jpg', 'plushie', 1),
('Mario Bros 3D Boo Light', 'Super Mario Bros 3D Boo Light - Officially Licensed Nintendo Merchandise, Mood Light for Home or Office Documentation, Gift for Retro Gamers.', 25.99, 'https://m.media-amazon.com/images/I/51yF88fmh+S._AC_SL1500_.jpg', 'figure', 1),
('Minecraft Creeper Plush', 'MUNSKT Mine-Craft Creeper Plush, Mine-Craft Plush Toy, 26 cm Characters, A Range of Toys for Fans and Children, Birthday Gifts or Fans for Children, Creeper Peripheral Derivatives, Pack of 1.', 19.99, 'https://m.media-amazon.com/images/I/71U0nyxPTLL._AC_SL1500_.jpg', 'plushie', 1),
('Mario Bros. Poster', '1art1 Super Mario Poster Bros. 3, Princess Peach, Luigi Pictures Canvas Picture on Stretcher Frame XXL Wall Picture Poster Art Print as Canvas 80 x 60 cm.', 44.99, 'https://m.media-amazon.com/images/I/51syMV8jWGL._AC_.jpg', 'poster', 1);
