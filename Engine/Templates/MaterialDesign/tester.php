<?php

namespace Engine;

use Engine\Addons\Auth\User;
use Engine\Addons\Books\Books;

User::onlyForAdmins();

//Debug::var_dump(Books::getByOffset());

Books::addBook('Книга OOOAлександра', 'Aлександр', '
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc et nulla non sapien condimentum dignissim. Sed ante est, dictum vitae tempor sed, sollicitudin vitae urna. Nullam condimentum mauris sed justo euismod, sit amet vulputate nibh commodo. Vestibulum eu placerat nisi, ac iaculis erat. Quisque scelerisque, nisl sit amet lacinia mattis, odio sapien porttitor orci, sagittis pharetra mi turpis elementum sapien. Sed turpis nunc, lobortis a nunc non, rhoncus tincidunt neque. Cras nec dui neque.

Fusce aliquet turpis non pharetra facilisis. Cras a sagittis erat. Nulla convallis fringilla cursus. Sed sit amet dolor eros. Aliquam ut sem in ante consequat sodales ut ut neque. Sed vitae posuere turpis. Suspendisse cursus eleifend nunc, vel molestie velit ultricies in. Mauris venenatis fringilla libero nec auctor. Quisque sed massa sit amet dolor dapibus ultrices. Fusce dapibus convallis turpis nec suscipit. Duis sed dolor semper, blandit libero ac, luctus ipsum. Sed a ligula lorem. Praesent rhoncus augue non augue rutrum, et porttitor lorem bibendum. Nulla venenatis in mi sed aliquam. Curabitur dapibus vestibulum ornare.

Quisque erat elit, tristique id consequat sit amet, venenatis non nibh. Aliquam tincidunt, mi quis accumsan venenatis, orci magna venenatis purus, vel suscipit justo erat ac dui. Sed vulputate lectus eu justo lobortis venenatis. Aliquam consectetur sapien a nisl hendrerit rhoncus. Etiam tempor justo risus, eget tristique mauris volutpat eu. Aliquam porttitor sem vel lectus venenatis vehicula. Integer sed dolor non leo ullamcorper efficitur. Ut dignissim venenatis bibendum. Morbi faucibus leo massa, ac rutrum sem gravida eu. Quisque non tincidunt lacus. Fusce malesuada lectus dolor, sit amet elementum urna ullamcorper a.

Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Ut leo nulla, finibus at orci vel, pretium convallis erat. Donec eu quam at quam rhoncus gravida sit amet eget massa. Vivamus ac nisl ullamcorper, consectetur turpis sed, maximus nunc. Sed placerat auctor ultricies. Curabitur consectetur a augue in consectetur. Sed at quam vel nulla tincidunt fermentum in ac massa. Curabitur tincidunt dui vitae iaculis eleifend. Suspendisse dui ligula, tincidunt eu mi quis, pulvinar tempor est. Aenean venenatis ex id interdum interdum. Sed ut porttitor augue. Ut sed nulla elit. Suspendisse molestie lacus nibh, eget placerat diam efficitur ac. Mauris tincidunt egestas ex at consequat. Cras cursus felis sapien, eget ultrices felis mattis a. Pellentesque fermentum sagittis justo, sit amet condimentum nisl commodo varius.

Morbi ac purus turpis. Aliquam a venenatis neque. Integer volutpat mauris nisl, ac fringilla nibh imperdiet eget. Donec lacinia, ipsum quis cursus aliquet, urna tortor elementum odio, eget fermentum ante lacus nec tellus. Aenean mollis tincidunt cursus. Pellentesque volutpat vitae sem a sodales. Etiam vehicula dapibus aliquam. Vivamus dictum leo id nisi dictum sollicitudin. Vivamus non nisi congue, ullamcorper nulla quis, rutrum nulla. Nullam posuere euismod ultricies. Maecenas aliquam diam at lorem imperdiet, a aliquam turpis molestie.', 1, false);

//Books::addBookHistoryById(1, 1, 'read');

//use Engine\Addons\Auth\Transfer;

//var_dump(Transfer::addTransfer(3, 2));