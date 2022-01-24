/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package operations;

import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Array;
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
public class UpDelSong extends HttpServlet {

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
            String name=request.getParameter("name");
            String updel=request.getParameter("updel");
            if(updel.equals("delete"))
            {
                String searchSql="select id from songs where name=?";
                PreparedStatement search=connection.prepareStatement(searchSql);
                search.setString(1, name);
                ResultSet result=search.executeQuery();
                if(!result.first())
                {
                    out.println("There aren't songs called "+name+", please digit another name!");
                    return;
                }
                long id=result.getLong("id");
                String deleteSql="delete from songs where id=?";
                PreparedStatement delete=connection.prepareStatement(deleteSql);
                delete.setLong(1, id);
                delete.executeUpdate();
                out.println(name+" deleted from DB!");
                connection.commit();
                return;
            }
            String duration=request.getParameter("duration");
            String getSql="select id from songs where name=?";
            PreparedStatement get=connection.prepareStatement(getSql);
            get.setString(1,name);
            ResultSet set=get.executeQuery();
           if(!set.first())
           {
               out.println("This song isn't in DB, please digits another one!");
               return;
           }
            long song=set.getLong("id");
            if(updel.equals("remove"))
            {
                printRemoveForm(request,out,song);
                return;
            }
            if(!duration.equals(""))
            {
                String[] parts=duration.split(":");
                float time=Float.parseFloat(parts[0])+Float.parseFloat(parts[1])/100;
                String updateSql="update songs set duration=? where id=?";
                PreparedStatement update=connection.prepareStatement(updateSql);
                update.setFloat(1,time);
                update.setLong(2,song);
                update.executeUpdate();
            }
            String firstSql="select products.id from products join cds on products.id=cds.product join cd_song on cds.product=cd_song.album where song=?";
            PreparedStatement first=connection.prepareStatement(firstSql);
            first.setLong(1,song);
            ResultSet resultCD=first.executeQuery();
            String secondSql="select products.id from products join vinils on products.id=vinils.product join vinil_song on vinils.product=vinil_song.album where song=?";
            PreparedStatement second=connection.prepareStatement(secondSql);
            second.setLong(1,song);
            ResultSet resultVinil=second.executeQuery();
            String values[]=updel.split("-");
            int cds=Integer.parseInt(values[0]);
            int vinils=Integer.parseInt(values[1]);
            ArrayList<Long> albums=new ArrayList<Long>();
            if(resultCD.first())
            {
                
    
                do albums.add(resultCD.getLong("id")); while(resultCD.next());
                  
            }
            int cdSame=0;
            for(int i=0;i<cds;i++)
                {
                    String check=request.getParameter("cd"+i);
                    if(check!=null)
                    {
                        long album=Long.parseLong(check);
                        if(albums.contains(album)) cdSame++;
                        else
                        {
                            out.println("ok");
                            String insertSql="insert into cd_song set album=?, song=?";
                            PreparedStatement insert=connection.prepareStatement(insertSql);
                            insert.setLong(1,album);
                            insert.setLong(2,song);
                            insert.executeUpdate();
                        }

                    }
                    
                }
               
               if(cdSame!=0) out.println(cdSame+" cds'songs not inserted because already in DB!\n");
            albums=new ArrayList<Long>();
            int vinilSame=0;
             if(resultVinil.first())
            {
                
                do albums.add(resultVinil.getLong("id")); while(resultVinil.next());
               
            }
             for(int i=0;i<vinils;i++)
                {
                    String check=request.getParameter("vinil"+i);
                    if(check!=null)
                    {
                        long album=Long.parseLong(check);
                        if(albums.contains(album)) vinilSame++;
                        else
                        {
                            String insertSql="insert into vinil_song set album=?, song=?";
                            PreparedStatement insert=connection.prepareStatement(insertSql);
                            insert.setLong(1,album);
                            insert.setLong(2,song);
                            insert.executeUpdate();
                        }

                    }
                    
                }
               
               if(vinilSame!=0) out.println(vinilSame+" vinils'songs not inserted because already in DB!\n");
           out.println(name+" updated!\n");
           
           connection.commit();
        } catch (SQLException ex) {
            try {
                out.println(ex.getMessage());
                connection.rollback();
            } catch (SQLException ex1) {
                out.println(ex1.getMessage());
                Logger.getLogger(UpDelSong.class.getName()).log(Level.SEVERE, null, ex1);
            }
              Logger.getLogger(UpDelSong.class.getName()).log(Level.SEVERE, null, ex);
          } finally {
//connection.close();
                        out.close();
        }
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

    private void printRemoveForm(HttpServletRequest request, PrintWriter out, long song) throws SQLException
    {
        out.println("<form method='post' action='/Managing/RemoveSong'>");
        String name=request.getParameter("name");
        out. println("<h4>Select albums you want to remove '"+name+"' from:</h4>");
        /*String parts[]=value.split("-");
        int cds=Integer.parseInt(parts[0]);
        int vinils=Integer.parseInt(parts[0]);*/
        String getSql="select id,name from products join cds on products.id=cds.product join cd_song on cds.product=cd_song.album where song=?";
        PreparedStatement get=connection.prepareStatement(getSql);
        get.setLong(1, song);
        ResultSet set=get.executeQuery();
        int cd=0,vinil=0;
        if(set.first())
        {
           
            //int num=0;
           do
           {
               String cdName=set.getString("name");
               long cdId=set.getLong("id");
               out.println("<div>");
               out.println(String.format("<input type='checkbox' value='%d' name='cd%d' id='cd%d'/>",cdId,cd,cd));
               out.println("<label>"+cdName+"</label>");
               out.println("</div>");
               cd++;
           }
           while(set.next());
        }
        else out.println("there are no cds in the DB!");
        getSql="select id,name from products join vinils on products.id=vinils.product join vinil_song on vinils.product=vinil_song.album where song=?";
        get=connection.prepareStatement(getSql);
        get.setLong(1, song);
        set=get.executeQuery();
        if(set.first())
        {
           
           do
           {
               String vinilName=set.getString("name");
               long vinilId=set.getLong("id");
               out.println("<div>");
               out.println(String.format("<input type='checkbox' value='%d' name='vinil%d' id='vinil%d'/>",vinilId,vinil,vinil));
               out.println("<label>"+vinilName+"</label>");
               out.println("</div>");
               vinil++;
           }
           while(set.next());
        }
        else out.println("there are no vinils in the DB!");
        out.println("<button type='submit' name='remove' id='remove' value='"+song+"-"+cd+"-"+vinil+"'>Remove</button>");
        out.println("</form>");
    }

}
