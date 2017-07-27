Jluct Blog
========================

This project use Symfony 3

install
=======
1. Go to install dir
2. <code>git clone https://github.com/Jluct/TestBlog.git ./ && git checkout prod</code><br>
or download zip from https://github.com/Jluct/TestBlog/tree/prod
3. Run:<br>
<code>php bin/console doctrine:database:create<br>
php bin/console doctrine:schema:update --force</code>
4. Create file app/config/parameters.yml for example parameters.yml.dist


create user with admin role
=======
<code>jb:user:create:admin --firstname=admin --lastname=administrator --password=123456 --email=admin@mail.ru --active=true</code>