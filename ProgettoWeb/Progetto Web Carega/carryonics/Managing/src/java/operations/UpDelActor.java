/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 *
 * @author Marco-PC
 */
public class UpDelActor extends HttpServlet {

    /**
     * Processes requests for both HTTP <code>GET</code> and <code>POST</code>
     * methods.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    
     private Connection connection;
    private PreparedStatement control;
    private String sql;
    
    @Override
    public void init()
    {
        try {
            Class.forName("com.mysql.jdbc.Driver");
            connection=DriverManager.getConnection("jdbc:mysql://localhost:3306/carryonics","root","");
            sql="select id,name,amount from products where name=?";
            control=connection.prepareStatement(sql);
           connection.setAutoCommit(false);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        } catch (SQLException ex) {
            Logger.getLogger(Insert.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        response.setContentType("text/html;charset=UTF-8");
        PrintWriter out = response.getWriter();
        try {
            /* TODO output your page here. You may use following sample code. */
             String name=request.getParameter("name");
             String surname=request.getParameter("surname");
            String updel=request.getParameter("updel");
            if(updel.equals("delete"))
            {
                String searchSql="select id from actors where name=? and surname=?";
                PreparedStatement search=connection.prepareStatement(searchSql);
                search.setString(1, name);
                 search.setString(2, surname);
                ResultSet result=search.executeQuery();
                if(!result.first())
                {
                    out.println("There aren't actors called "+name+" "+surname+", please digit another name!");
                    return;
                }
                long id=result.getLong("id");
                String deleteSql="delete from actors where id=?";
                PreparedStatement delete=connection.prepareStatement(deleteSql);
                delete.setLong(1, id);
                delete.executeUpdate();
                out.println(name+" deleted from DB!");
                connection.commit();
                return;
            }
            
            String getSql="select id from actors where name=? and surname=?";
            PreparedStatement get=connection.prepareStatement(getSql);
            get.setString(1,name);
            get.setString(2,surname);
            ResultSet set=get.executeQuery();
           if(!set.first())
           {
               out.println("This actor isn't in DB, please digits another one!");
               return;
           }
            long actor=set.getLong("id");
            if(updel.equals("remove"))
            {
                printRemoveForm(request,out,actor);
                return;
            }
           
            String firstSql="select products.id from products join films on products.id=films.product join film_actor on films.product=film_actor.film where actor=?";
            PreparedStatement first=connection.prepareStatement(firstSql);
            first.setLong(1,actor);
            ResultSet result=first.executeQuery();
            int num=Integer.parseInt(updel);
            ArrayList<Long> films=new ArrayList<Long>();
            if(result.first())
            {
                do films.add(result.getLong("id")); while(result.next()); 
                //out.println("ok");
            }
            int same=0;
            //out.println(num);
            for(int i=0;i<num;i++)
                {
                    //out.println("ook");
                    String check=request.getParameter(String.valueOf(i));
                   //out.println(check);
                    if(check!=null)
                    {
                        
                        //out.println("check:"+check);
                        long film=Long.parseLong(check);
                        //out.println("film:"+film);
                        if(films.contains(film)) same++;
                        else
                        {
                           // out.println("ok");
                            String insertSql="insert into film_actor set film=?, actor=?";
                            PreparedStatement insert=connection.prepareStatement(insertSql);
                            insert.setLong(1,film);
                            insert.setLong(2,actor);
                            insert.executeUpdate();
                        }

                    }
                    
                }
               //out.println(same);
               if(same!=0) out.println(same+" films's actors not inserted because already in DB!\n");
                out.println(name+" updated!\n");
           
           connection.commit();
        } catch (SQLException ex) {
            try {
                connection.rollback();
            } catch (SQLException ex1) {
                Logger.getLogger(UpDelActor.class.getName()).log(Level.SEVERE, null, ex1);
            }
            out.println(ex.getMessage());
            Logger.getLogger(UpDelActor.class.getName()).log(Level.SEVERE, null, ex);
        } finally {
            out.close();
        }
    }
    
    private void printRemoveForm(HttpServletRequest request, PrintWriter out, long actor) throws SQLException
    {
        out.println("<form method='post' action='/Managing/RemoveActor'>");
        String name=request.getParameter("name");
        out. println("<h4>Select albums you want to remove '"+name+"' from:</h4>");
        /*String parts[]=value.split("-");
        int cds=Integer.parseInt(parts[0]);
        int vinils=Integer.parseInt(parts[0]);*/
        String getSql="select id,name from products join films on products.id=films.product join film_actor on films.product=film_actor.film where actor=?";
        PreparedStatement get=connection.prepareStatement(getSql);
        get.setLong(1, actor);
        ResultSet set=get.executeQuery();
        int num=0;
        if(set.first())
        {
           
            //int num=0;
           do
           {
               String filmName=set.getString("name");
               long filmId=set.getLong("id");
               out.println("<div>");
               out.println(String.format("<input type='checkbox' value='%d' name='%d' id='%d'/>",filmId,num,num));
               out.println("<label>"+filmName+"</label>");
               out.println("</div>");
               num++;
           }
           while(set.next());
        }
        else out.println("there are no films in the DB!");
        
        out.println("<button type='submit' name='remove' id='remove' value='"+actor+"-"+num+"'>Remove</button>");
        out.println("</form>");
    }
    

    // <editor-fold defaultstate="collapsed" desc="HttpServlet methods. Click on the + sign on the left to edit the code.">
    /**
     * Handles the HTTP <code>GET</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Handles the HTTP <code>POST</code> method.
     *
     * @param request servlet request
     * @param response servlet response
     * @throws ServletException if a servlet-specific error occurs
     * @throws IOException if an I/O error occurs
     */
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    /**
     * Returns a short description of the servlet.
     *
     * @return a String containing servlet description
     */
    @Override
    public String getServletInfo() {
        return "Short description";
    }// </editor-fold>

}
