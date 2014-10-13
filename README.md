Twitter Bootstrap para Magento
=========================

CONFIGURAÇÃO
============

> Copie o conteudo em /src/ para o diretório raiz do Magento.
> Gerencie seus banners no menu do painel administrativo do magento.

UTILIZAR OS BANNERS
===================

> Bloco:
> <block type="carousel/carousel" name="[NOME]" alias="[ALIAS]" template="[PATH]" />

> PHP:
> <?php echo $this->getLayout()->createBlock('carousel/carousel')->setTemplate('[PATH]')->toHtml(); ?>

SELECIONAR CATEGORIA
====================

> Ao chamar o método: 
> $carousel = $this->getDataCarousel('banner1');