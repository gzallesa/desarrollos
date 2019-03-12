<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appDevUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // helpdesk_homepage
        if ($pathinfo === '/inicio') {
            return array (  '_controller' => 'Panel\\HelpdeskBundle\\Controller\\DefaultController::indexAction',  '_route' => 'helpdesk_homepage',);
        }

        // helpdesk_homepage2
        if ($pathinfo === '/sol') {
            return array (  '_controller' => 'Panel\\HelpdeskBundle\\Controller\\DefaultController::solicitudesAction',  '_route' => 'helpdesk_homepage2',);
        }

        if (0 === strpos($pathinfo, '/a')) {
            // helpdesk_abiertas
            if ($pathinfo === '/abiertas') {
                return array (  '_controller' => 'Panel\\HelpdeskBundle\\Controller\\DefaultController::abiertasAction',  '_route' => 'helpdesk_abiertas',);
            }

            // admin_page_homepage
            if (0 === strpos($pathinfo, '/adminpage') && preg_match('#^/adminpage/(?P<t>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_homepage')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::indexAction',));
            }

        }

        // admin_page_Comunicado
        if ($pathinfo === '/comunicado') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::comunicadoAction',  '_route' => 'admin_page_Comunicado',);
        }

        // admin_page_Anuncio
        if ($pathinfo === '/anuncio') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::anuncioAction',  '_route' => 'admin_page_Anuncio',);
        }

        // admin_page_Video
        if ($pathinfo === '/video') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::videoAction',  '_route' => 'admin_page_Video',);
        }

        if (0 === strpos($pathinfo, '/guardar')) {
            // admin_page_guardarAnuncio
            if ($pathinfo === '/guardarAnuncio') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::guardarAnuncioAction',  '_route' => 'admin_page_guardarAnuncio',);
            }

            // admin_page_guardarComunicado
            if ($pathinfo === '/guardarComunicado') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::guardarComunicadoAction',  '_route' => 'admin_page_guardarComunicado',);
            }

            // admin_page_guardarVideo
            if ($pathinfo === '/guardarVideo') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::guardarVideoAction',  '_route' => 'admin_page_guardarVideo',);
            }

        }

        // admin_page_formulario
        if ($pathinfo === '/formulario') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::formularioAction',  '_route' => 'admin_page_formulario',);
        }

        // admin_page_upload
        if ($pathinfo === '/up') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::uploadAction',  '_route' => 'admin_page_upload',);
        }

        // admin_page_prueba
        if ($pathinfo === '/prueba') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::pruebaAction',  '_route' => 'admin_page_prueba',);
        }

        // admin_page_comunicadoPanel
        if ($pathinfo === '/comunicadoPanel') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::comunicadoPanelAction',  '_route' => 'admin_page_comunicadoPanel',);
        }

        // admin_page_anuncios
        if ($pathinfo === '/anuncios') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getAnunciosAction',  '_route' => 'admin_page_anuncios',);
        }

        // admin_page_getContenido
        if (0 === strpos($pathinfo, '/contenido') && preg_match('#^/contenido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_getContenido')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getContenidoAction',));
        }

        // admin_page_getComunicado
        if (0 === strpos($pathinfo, '/getComunicado') && preg_match('#^/getComunicado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_getComunicado')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getComunicadoAction',));
        }

        if (0 === strpos($pathinfo, '/del')) {
            // admin_page_delContenido
            if (0 === strpos($pathinfo, '/delcontenido') && preg_match('#^/delcontenido/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_delContenido')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::eliminarAnuncioAction',));
            }

            // admin_page_delComunicado
            if (0 === strpos($pathinfo, '/delComunicado') && preg_match('#^/delComunicado/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_delComunicado')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::eliminarComunicadoAction',));
            }

        }

        if (0 === strpos($pathinfo, '/modificar')) {
            // admin_page_modificarAnuncio
            if ($pathinfo === '/modificarAnuncio') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::modificarAnuncioAction',  '_route' => 'admin_page_modificarAnuncio',);
            }

            // admin_page_modificarComunicado
            if ($pathinfo === '/modificarComunicado') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::modificarComunicadoAction',  '_route' => 'admin_page_modificarComunicado',);
            }

        }

        if (0 === strpos($pathinfo, '/upload')) {
            // admin_page_uploader
            if ($pathinfo === '/upload') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::uploadAction',  '_route' => 'admin_page_uploader',);
            }

            // admin_page_uploadfile
            if ($pathinfo === '/uploadfile') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::uploadFileAction',  '_route' => 'admin_page_uploadfile',);
            }

        }

        if (0 === strpos($pathinfo, '/get')) {
            if (0 === strpos($pathinfo, '/getu')) {
                // admin_page_getusers
                if ($pathinfo === '/getusers') {
                    return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getusersAction',  '_route' => 'admin_page_getusers',);
                }

                // admin_page_getu
                if ($pathinfo === '/getu') {
                    return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getuAction',  '_route' => 'admin_page_getu',);
                }

            }

            // admin_page_getsoportes
            if ($pathinfo === '/getsoportes') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getSoportesAction',  '_route' => 'admin_page_getsoportes',);
            }

        }

        // admin_page_videoform
        if ($pathinfo === '/videoform') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::videoformAction',  '_route' => 'admin_page_videoform',);
        }

        if (0 === strpos($pathinfo, '/get')) {
            // admin_page_getsoportes2
            if ($pathinfo === '/getsoportes2') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getSoportes2Action',  '_route' => 'admin_page_getsoportes2',);
            }

            // admin_page_getoficinas
            if ($pathinfo === '/getoficinas') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getOficinasAction',  '_route' => 'admin_page_getoficinas',);
            }

        }

        // save_user
        if ($pathinfo === '/saveuser') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::saveUserAction',  '_route' => 'save_user',);
        }

        // update_user
        if ($pathinfo === '/updateuser') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::updateUserAction',  '_route' => 'update_user',);
        }

        // admin_page_popupPanel
        if ($pathinfo === '/popupPanel') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::popupPanelAction',  '_route' => 'admin_page_popupPanel',);
        }

        // admin_page_createPopup
        if ($pathinfo === '/createPopup') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::createPopupAction',  '_route' => 'admin_page_createPopup',);
        }

        // admin_page_getPopup
        if (0 === strpos($pathinfo, '/getPopup') && preg_match('#^/getPopup/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_getPopup')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getPopupAction',));
        }

        // admin_page_deletePopup
        if (0 === strpos($pathinfo, '/deletePopup') && preg_match('#^/deletePopup/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_deletePopup')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::deletePopupAction',));
        }

        // admin_page_guardarPopup
        if ($pathinfo === '/guardarPopup') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::guardarPopupAction',  '_route' => 'admin_page_guardarPopup',);
        }

        // admin_page_modificarPopup
        if ($pathinfo === '/modificarPopup') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::modificarPopupAction',  '_route' => 'admin_page_modificarPopup',);
        }

        // admin_page_reglamentoPanel
        if ($pathinfo === '/reglamentoPanel') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::reglamentoPanelAction',  '_route' => 'admin_page_reglamentoPanel',);
        }

        // admin_page_createReglamento
        if ($pathinfo === '/createReglamento') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::createReglamentoAction',  '_route' => 'admin_page_createReglamento',);
        }

        if (0 === strpos($pathinfo, '/g')) {
            // admin_page_getReglamento
            if (0 === strpos($pathinfo, '/getReglamento') && preg_match('#^/getReglamento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_getReglamento')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::getReglamentoAction',));
            }

            // admin_page_guardarReglamento
            if ($pathinfo === '/guardarReglamento') {
                return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::guardarReglamentoAction',  '_route' => 'admin_page_guardarReglamento',);
            }

        }

        // admin_page_modificarReglamento
        if ($pathinfo === '/modificarReglamento') {
            return array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::modificarReglamentoAction',  '_route' => 'admin_page_modificarReglamento',);
        }

        // admin_page_eliminarReglamento
        if (0 === strpos($pathinfo, '/eliminarReglamento') && preg_match('#^/eliminarReglamento/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_page_eliminarReglamento')), array (  '_controller' => 'Support\\AdminPageBundle\\Controller\\DefaultController::eliminarReglamentoAction',));
        }

        // admin_homepage
        if ($pathinfo === '/administrator') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::indexAction',  '_route' => 'admin_homepage',);
        }

        // admin_soporte
        if ($pathinfo === '/soptec') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getSolicitudesAction',  '_route' => 'admin_soporte',);
        }

        // admin_charts
        if ($pathinfo === '/charts') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getChartsAction',  '_route' => 'admin_charts',);
        }

        // admin_supports
        if ($pathinfo === '/supports') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::supportsAction',  '_route' => 'admin_supports',);
        }

        // admin_getSupportsChart
        if (0 === strpos($pathinfo, '/getSupportsChart') && preg_match('#^/getSupportsChart/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_getSupportsChart')), array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getSupportsChartAction',));
        }

        // admin_control
        if ($pathinfo === '/control') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::controlAction',  '_route' => 'admin_control',);
        }

        // admin_grilla
        if ($pathinfo === '/grilla') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::grillaAction',  '_route' => 'admin_grilla',);
        }

        // admin_grilla_getsolicitudes
        if ($pathinfo === '/solicitudesgrilla') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getJSONSolicitudesAction',  '_route' => 'admin_grilla_getsolicitudes',);
        }

        // admin_panel
        if ($pathinfo === '/panel') {
            return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::panelAction',  '_route' => 'admin_panel',);
        }

        if (0 === strpos($pathinfo, '/b')) {
            // admin_est_bars
            if ($pathinfo === '/bars') {
                return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::barsAction',  '_route' => 'admin_est_bars',);
            }

            // admin_est_bubble
            if ($pathinfo === '/bubble') {
                return array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::bubbleAction',  '_route' => 'admin_est_bubble',);
            }

        }

        // admin_detalle_pie
        if (0 === strpos($pathinfo, '/detallepie') && preg_match('#^/detallepie/(?P<val>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_detalle_pie')), array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::detallePieAction',));
        }

        // admin_detalle_pieJson
        if (0 === strpos($pathinfo, '/getJSONDetallePieAction') && preg_match('#^/getJSONDetallePieAction/(?P<val>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_detalle_pieJson')), array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getJSONDetallePieAction',));
        }

        // admin_detalle_bubble
        if (0 === strpos($pathinfo, '/detallebubble') && preg_match('#^/detallebubble/(?P<problema>[^/]++)/(?P<soporte>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_detalle_bubble')), array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::detalleBubbleAction',));
        }

        // admin_detalle_bubbleJson
        if (0 === strpos($pathinfo, '/getJSONDetalleBubbleAction') && preg_match('#^/getJSONDetalleBubbleAction/(?P<problema>[^/]++)/(?P<soporte>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'admin_detalle_bubbleJson')), array (  '_controller' => 'Support\\AdminBundle\\Controller\\DefaultController::getJSONDetalleBubbleAction',));
        }

        // cliente_comunicados_paginado
        if ($pathinfo === '/comunicadosPag') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::comunicadosPagAction',  '_route' => 'cliente_comunicados_paginado',);
        }

        // cliente_homepage
        if (rtrim($pathinfo, '/') === '') {
            if (substr($pathinfo, -1) !== '/') {
                return $this->redirect($pathinfo.'/', 'cliente_homepage');
            }

            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::indexAction',  '_route' => 'cliente_homepage',);
        }

        // cliente_enviar
        if ($pathinfo === '/enviar') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::enviarAction',  '_route' => 'cliente_enviar',);
        }

        // cliente_finalizar
        if ($pathinfo === '/finalizar') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::finalizarAction',  '_route' => 'cliente_finalizar',);
        }

        if (0 === strpos($pathinfo, '/lista')) {
            // cliente_listar
            if ($pathinfo === '/lista_usuarios') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getUsersAction',  '_route' => 'cliente_listar',);
            }

            // cliente_lista_usuarios
            if ($pathinfo === '/listar') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::listaAction',  '_route' => 'cliente_lista_usuarios',);
            }

        }

        // cliente_slider
        if ($pathinfo === '/slider') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::sliderAction',  '_route' => 'cliente_slider',);
        }

        // cliente_calendar
        if ($pathinfo === '/calendar') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::calendarAction',  '_route' => 'cliente_calendar',);
        }

        // cliente_events
        if ($pathinfo === '/events') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getEventsAction',  '_route' => 'cliente_events',);
        }

        if (0 === strpos($pathinfo, '/c')) {
            // cliente_comunicados
            if ($pathinfo === '/comunicados') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getComunicadosAction',  '_route' => 'cliente_comunicados',);
            }

            // cliente_cumple
            if ($pathinfo === '/cumple') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getCumpleAction',  '_route' => 'cliente_cumple',);
            }

        }

        // cliente_ticker
        if ($pathinfo === '/ticker') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getTickerAction',  '_route' => 'cliente_ticker',);
        }

        // cliente_monitoreoAction
        if (0 === strpos($pathinfo, '/monitoreo') && preg_match('#^/monitoreo/(?P<url>.+)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'cliente_monitoreoAction')), array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::monitoreoAction',));
        }

        // cliente_chat
        if ($pathinfo === '/chat') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::chatAction',  '_route' => 'cliente_chat',);
        }

        // cliente_flip
        if ($pathinfo === '/flip') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::flipAction',  '_route' => 'cliente_flip',);
        }

        if (0 === strpos($pathinfo, '/resol')) {
            // cliente_grilla
            if ($pathinfo === '/resolgrilla') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::grillaAction',  '_route' => 'cliente_grilla',);
            }

            // cliente_resoluciones
            if ($pathinfo === '/resoluciones') {
                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::resolucionesAction',  '_route' => 'cliente_resoluciones',);
            }

        }

        // cliente_eventos1
        if ($pathinfo === '/getEventos') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getEventosAction',  '_route' => 'cliente_eventos1',);
        }

        // cliente_service
        if ($pathinfo === '/service') {
            return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::serviceAction',  '_route' => 'cliente_service',);
        }

        if (0 === strpos($pathinfo, '/api/get')) {
            // intranet_ws_getContenidoIntranet
            if (0 === strpos($pathinfo, '/api/getContenidoIntranet') && preg_match('#^/api/getContenidoIntranet/(?P<limit>[^/]++)/(?P<offset>[^/]++)/?$#s', $pathinfo, $matches)) {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'intranet_ws_getContenidoIntranet');
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'intranet_ws_getContenidoIntranet')), array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getContenidoIntranetAction',));
            }

            // intranet_ws_getOficinasIntranet
            if (rtrim($pathinfo, '/') === '/api/getOficinasIntranet') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'intranet_ws_getOficinasIntranet');
                }

                return array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getOficinasIntranetAction',  '_route' => 'intranet_ws_getOficinasIntranet',);
            }

            // intranet_ws_getContenidoPorOficinaIntranet
            if (0 === strpos($pathinfo, '/api/getContenidoPorOficinaIntranet') && preg_match('#^/api/getContenidoPorOficinaIntranet/(?P<idOficina>[^/]++)/(?P<limit>[^/]++)/(?P<offset>[^/]++)/?$#s', $pathinfo, $matches)) {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'intranet_ws_getContenidoPorOficinaIntranet');
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'intranet_ws_getContenidoPorOficinaIntranet')), array (  '_controller' => 'Support\\ClienteBundle\\Controller\\DefaultController::getContenidoPorOficinaIntranetAction',));
            }

        }

        if (0 === strpos($pathinfo, '/docmanuser')) {
            // docmanuser
            if (rtrim($pathinfo, '/') === '/docmanuser') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'docmanuser');
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::indexAction',  '_route' => 'docmanuser',);
            }

            // docmanuser_show
            if (preg_match('#^/docmanuser/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmanuser_show')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::showAction',));
            }

            // docmanuser_new
            if ($pathinfo === '/docmanuser/new') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::newAction',  '_route' => 'docmanuser_new',);
            }

            // docmanuser_create
            if ($pathinfo === '/docmanuser/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_docmanuser_create;
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::createAction',  '_route' => 'docmanuser_create',);
            }
            not_docmanuser_create:

            // docmanuser_edit
            if (preg_match('#^/docmanuser/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmanuser_edit')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::editAction',));
            }

            // docmanuser_update
            if (preg_match('#^/docmanuser/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_docmanuser_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmanuser_update')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::updateAction',));
            }
            not_docmanuser_update:

            // docmanuser_delete
            if (preg_match('#^/docmanuser/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_docmanuser_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmanuser_delete')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanUserController::deleteAction',));
            }
            not_docmanuser_delete:

        }

        if (0 === strpos($pathinfo, '/evento')) {
            // evento
            if (rtrim($pathinfo, '/') === '/evento') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'evento');
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::indexAction',  '_route' => 'evento',);
            }

            // evento_show
            if (preg_match('#^/evento/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evento_show')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::showAction',));
            }

            // evento_new
            if ($pathinfo === '/evento/new') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::newAction',  '_route' => 'evento_new',);
            }

            // evento_create
            if ($pathinfo === '/evento/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_evento_create;
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::createAction',  '_route' => 'evento_create',);
            }
            not_evento_create:

            // evento_edit
            if (preg_match('#^/evento/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evento_edit')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::editAction',));
            }

            // evento_update
            if (preg_match('#^/evento/(?P<id>[^/]++)/update$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_evento_update;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evento_update')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::updateAction',));
            }
            not_evento_update:

            // evento_delete
            if (preg_match('#^/evento/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_evento_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'evento_delete')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\EventoController::deleteAction',));
            }
            not_evento_delete:

        }

        if (0 === strpos($pathinfo, '/dcontenido')) {
            // docmancontenido
            if (rtrim($pathinfo, '/') === '/dcontenido') {
                if (substr($pathinfo, -1) !== '/') {
                    return $this->redirect($pathinfo.'/', 'docmancontenido');
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::indexAction',  '_route' => 'docmancontenido',);
            }

            // docmancontenido_show
            if (preg_match('#^/dcontenido/(?P<id>[^/]++)/show$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmancontenido_show')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::showAction',));
            }

            // docmancontenido_new
            if ($pathinfo === '/dcontenido/new') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::newAction',  '_route' => 'docmancontenido_new',);
            }

            // docmancontenido_create
            if ($pathinfo === '/dcontenido/create') {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_docmancontenido_create;
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::createAction',  '_route' => 'docmancontenido_create',);
            }
            not_docmancontenido_create:

            // docmancontenido_edit
            if (preg_match('#^/dcontenido/(?P<id>[^/]++)/edit$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmancontenido_edit')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::editAction',));
            }

            // docmancontenido_update
            if ($pathinfo === '/dcontenido/update') {
                if (!in_array($this->context->getMethod(), array('POST', 'PUT'))) {
                    $allow = array_merge($allow, array('POST', 'PUT'));
                    goto not_docmancontenido_update;
                }

                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::updateAction',  '_route' => 'docmancontenido_update',);
            }
            not_docmancontenido_update:

            // docmancontenido_delete
            if (preg_match('#^/dcontenido/(?P<id>[^/]++)/delete$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('POST', 'DELETE'))) {
                    $allow = array_merge($allow, array('POST', 'DELETE'));
                    goto not_docmancontenido_delete;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'docmancontenido_delete')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DocmanContenidoController::deleteAction',));
            }
            not_docmancontenido_delete:

        }

        if (0 === strpos($pathinfo, '/log')) {
            if (0 === strpos($pathinfo, '/login')) {
                // support_support_login
                if ($pathinfo === '/login') {
                    return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::loginAction',  '_route' => 'support_support_login',);
                }

                // support_support_login_check
                if ($pathinfo === '/login_check') {
                    return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::loginCheckAction',  '_route' => 'support_support_login_check',);
                }

            }

            // support_support_logout
            if ($pathinfo === '/logout') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::logoutAction',  '_route' => 'support_support_logout',);
            }

        }

        // support_support_mostrar
        if (0 === strpos($pathinfo, '/mostrar') && preg_match('#^/mostrar/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'support_support_mostrar')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::getSolicitudesAction',));
        }

        // support_support_panel
        if ($pathinfo === '/soporte') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::mostrarAction',  '_route' => 'support_support_panel',);
        }

        // support_support_getJsonSupport
        if ($pathinfo === '/JsonSupport') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::getJsonSupportAction',  '_route' => 'support_support_getJsonSupport',);
        }

        // support_support_uploader
        if ($pathinfo === '/uploader') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::uploaderAction',  '_route' => 'support_support_uploader',);
        }

        // support_transferir
        if ($pathinfo === '/transferir') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::transferirAction',  '_route' => 'support_transferir',);
        }

        if (0 === strpos($pathinfo, '/g')) {
            // support_grid
            if ($pathinfo === '/grid') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::gridAction',  '_route' => 'support_grid',);
            }

            if (0 === strpos($pathinfo, '/get')) {
                // support_getSolicitudes
                if ($pathinfo === '/getSolicitudes') {
                    return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::getJSONSolicitudesAction',  '_route' => 'support_getSolicitudes',);
                }

                // support_getBars
                if ($pathinfo === '/getBars') {
                    return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::getBarsAction',  '_route' => 'support_getBars',);
                }

            }

        }

        // support_update
        if ($pathinfo === '/update') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::updateAction',  '_route' => 'support_update',);
        }

        if (0 === strpos($pathinfo, '/g')) {
            // support_grid_popup
            if (0 === strpos($pathinfo, '/gridpopup') && preg_match('#^/gridpopup/(?P<intervalo>[^/]++)/(?P<problema>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'support_grid_popup')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::gridPopupAction',));
            }

            // support_getSolicitudesByProb
            if (0 === strpos($pathinfo, '/getSolicitudesByProb') && preg_match('#^/getSolicitudesByProb/(?P<intervalo>[^/]++)/(?P<problema>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => 'support_getSolicitudesByProb')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\DefaultController::getJSONSolicitudes2Action',));
            }

        }

        // fun_support_mostrar
        if (0 === strpos($pathinfo, '/mostrarx') && preg_match('#^/mostrarx/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'fun_support_mostrar')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\FunController::getSolicitudesAction',));
        }

        // fun_support_panel
        if ($pathinfo === '/soportesx') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\FunController::mostrarAction',  '_route' => 'fun_support_panel',);
        }

        // fun_support_getJsonSupport
        if ($pathinfo === '/JsonSupportx') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\FunController::getJsonSupportAction',  '_route' => 'fun_support_getJsonSupport',);
        }

        // fun_support_uploader
        if ($pathinfo === '/uploaderx') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\FunController::uploaderAction',  '_route' => 'fun_support_uploader',);
        }

        // fun_transferir
        if ($pathinfo === '/transferirx') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\FunController::transferirAction',  '_route' => 'fun_transferir',);
        }

        if (0 === strpos($pathinfo, '/g')) {
            // monitoreo_guardar
            if ($pathinfo === '/guardarMonitoreo') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\MonitoreoController::guardarMonitoreoAction',  '_route' => 'monitoreo_guardar',);
            }

            // monitoreo_get
            if ($pathinfo === '/getMonitoreo') {
                return array (  '_controller' => 'Support\\SupportBundle\\Controller\\MonitoreoController::getMonitoreoAction',  '_route' => 'monitoreo_get',);
            }

        }

        // monitoreo_monitoreo
        if ($pathinfo === '/monitoreo') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\MonitoreoController::monitoreoAction',  '_route' => 'monitoreo_monitoreo',);
        }

        // support_rest_add
        if ($pathinfo === '/add') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\RestFulController::addAction',  '_route' => 'support_rest_add',);
        }

        // support_rest_del
        if ($pathinfo === '/del') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\RestFulController::delAction',  '_route' => 'support_rest_del',);
        }

        // support_rest_update
        if ($pathinfo === '/update') {
            return array (  '_controller' => 'Support\\SupportBundle\\Controller\\RestFulController::updateAction',  '_route' => 'support_rest_update',);
        }

        // support_rest_list
        if (0 === strpos($pathinfo, '/list') && preg_match('#^/list/(?P<ids>[^/]++)$#s', $pathinfo, $matches)) {
            return $this->mergeDefaults(array_replace($matches, array('_route' => 'support_rest_list')), array (  '_controller' => 'Support\\SupportBundle\\Controller\\RestFulController::listAction',));
        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
